<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Services\StockTransaction\StockTransactionService;

class StockTransactionsController extends Controller
{
    protected $stockTransactionService;

    public function __construct(StockTransactionService $stockTransactionService) {
        $this->stockTransactionService = $stockTransactionService;
    }

    private function transactionValidation() {
        return [
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:Masuk,Keluar',
            'quantity' => 'required|integer|',
            'date' => 'nullable|date',
            'status' => 'required|in:Pending,Diterima,Ditolak,Dikeluarkan',
            'notes' => 'nullable|string',
        ];
    }

    private function isPdfRequest(Request $request) {
        return in_array($request->input('action'), ['print-transaction', 'print-stock']);
    }

    private function handlePdfGenerate(Request $request, $filters) {
        $action = $request->input('action', 'view');

        if ($action === 'print-transaction') {
            return $this->stockTransactionService->generatePdfByType($request->type);
        } elseif ($action === 'print-stock') {
            return $this->stockTransactionService->generatePdfByCriteria($filters);
        }
    }

    public function index(Request $request) {
        $categoriesData = $this->stockTransactionService->getAllCategoryByStock();
        $stockByType = $this->stockTransactionService->getTransactionByType($request->type);
        
        $filters = $request->only(['periods', 'categories', 'start_date', 'end_date']);
        $stockByCriteria = $this->stockTransactionService->getTransactionByCriteria($filters);
        
        if (isset($filters['categories'])) {
            $categoryName = $filters['categories'];
            $category = Categories::where('name', $categoryName)->first();
            $filters['categories'] = $category ? $category->id : null;
        }

        if($this->isPdfRequest($request)) {
            return $this->handlePdfGenerate($request, $filters);
        }

        return view('roles.admin.transaction.index', [
            'title' => 'History Stock Transaction',
            'category' => $categoriesData,
            'stockByType' => $stockByType,
            'stockByCriteria' => $stockByCriteria,
        ]);
    }

    public function opnameStockView() {
        $minimumStock = $this->stockTransactionService->getMinimumQuantityStock();

        return view('roles.admin.transaction.stock-opname', [
            'title' => 'Stock Opname',
            'minimumStock' => $minimumStock,
        ]);
    }

    public function store(Request $request) {
        $transaction = $request->validate($this->transactionValidation());
        $minimumStock = $this->stockTransactionService->getMinimumQuantityStock();

        if ($transaction['quantity'] - $request->quantity < $minimumStock) {
            return redirect()->back()->with('error', 'Jumlah stok yang tersedia tidak cukup untuk transaksi ini. Stok minimum: ' . $minimumStock);
        }

        $this->stockTransactionService->createTransaction($transaction, $request->quantity);
        notify()->preset('user-created', [
            'title' => 'Transaction Created',
            'message' => 'Stock Transaction has been created successfully'
        ]);

        return redirect()->route('transaction.index')->with('success', 'Stock Transaction created successfully.');
    }

    // public function performStockOpname($productId, $actualQty) {
    //     $transaction = $this->stockTransactionService->find($productId);
    //     $difference = $actualQty - $transaction->quantity;

    //     $transactionType = $difference > 0 ? 'Masuk' : 'Keluar';
    //     $this->stockTransactionService->createTransaction([
    //         'product_id' => $productId,
    //         'type' => $transactionType,
    //         'quantity' => abs($difference),
    //         'status' => 'Diterima',
    //         'notes' => 'Stock Opname Adjustment'
    //     ]);

    //     $transaction->quantity = $actualQty;
    //     $transaction->save();
    // }

    public function downloadReportByType(Request $request) {
        $type = $request->input('type');
        return $this->stockTransactionService->generatePdfByType($type);
    }

    public function downloadReportByCriteria(Request $request) {
        $criteria = $this->stockTransactionService->getTransactionByCriteria(
            $request->only(['periods', 'categories', 'start_date', 'end_date'])
        );
        return $this->stockTransactionService->generatePdfByCriteria($criteria, $request->all());
    }

    public function updateStockMinimum(Request $request) {
        $validated = $request->validate([
            'minimum_stock' => 'required|integer|min:0',
        ]);

        $this->stockTransactionService->updateMinimumQuantityStock($validated['minimum_stock']);
        return redirect()->back()->with('success', 'Stok minimum berhasil diperbarui.');
    }
}
