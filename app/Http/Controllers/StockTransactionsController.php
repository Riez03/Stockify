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
            'type' => 'required|in:Masuk,Keluar',
            'quantity' => 'required|integer|',
            'date' => 'nullable|date',
            'status' => 'required|in:Pending,Diterima,Ditolak,Dikeluarkan',
            'notes' => 'nullable|string',
        ];
    }

    private function isPdfRequest(Request $request) {
        return in_array($request->input('action'), [
            'print-transaction',
            'print-stock', 
            'printTypeManager'
        ]);
    }

    private function handlePdfGenerate(Request $request, $filters = []) {
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
        
        if (isset($filters['categories'])) {
            $categoryName = $filters['categories'];
            $category = Categories::where('name', $categoryName)->first();
            $filters['categories'] = $category ? $category->id : null;
        }

        // Moving the variable layout may result in errors in certain functions   
        $stockByCriteria = $this->stockTransactionService->getTransactionByCriteria($filters);

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

    public function mainTransaction(Request $request) { 
        $categoriesData = $this->stockTransactionService->getAllCategoryByStock();
        $suppliersData = $this->stockTransactionService->getAllSuppliersByStock();
        $productData = $this->stockTransactionService->getAllProductByStock();
        $stockByType = $this->stockTransactionService->getTransactionByType($request->type);
        $filters = $request->only(['periods', 'categories', 'start_date', 'end_date']);
        
        if (isset($filters['categories'])) {
            $categoryName = $filters['categories'];
            $category = Categories::where('name', $categoryName)->first();
            $filters['categories'] = $category ? $category->id : null;
        }

        $stockByCriteria = $this->stockTransactionService->getTransactionByCriteria($filters);

        if($this->isPdfRequest($request)) {
            return $this->handlePdfGenerate($request, $filters);
        }

        return view('roles.manager.stock.index', [
            'title' => 'Management Stock Transaction',
            'category' => $categoriesData,
            'supplier' => $suppliersData,
            'product' => $productData,
            'stockByType' => $stockByType,
            'stockByCriteria' => $stockByCriteria,
        ]);
    }

    public function opnameStockView() {
        $minimumStock = $this->stockTransactionService->getMinimumQuantityStock();
        $allTransaction = $this->stockTransactionService->getAllStockTransaction();

        return view('roles.admin.transaction.stock-opname', [
            'title' => 'Stock Opname',
            'minimumStock' => $minimumStock,
            'transaction' => $allTransaction,
        ]);
    }

    public function opnameStockManagerView() {
        $allTransaction = $this->stockTransactionService->getAllStockTransaction();

        return view('roles.manager.stock.opname', [
            'title' => 'Stock Opname',
            'transaction' => $allTransaction,
        ]);
    }

    public function confirmationStockView() {
        $getAllStock = $this->stockTransactionService->getAllStockWithoutPageRestrict();
        $getPendingStatus = $getAllStock->filter(function($item) {
            return $item->status === 'Pending';
        });

        return view('roles.staff.confirmation-stock', [
            'title' => 'Stock Check Confirmation',
            'data' => $getPendingStatus,
        ]);
    }

    public function store(Request $request) {
        $transaction = $request->validate($this->transactionValidation());
        $transaction['user_id'] = auth()->id();        

        $minimumStock = $this->stockTransactionService->getMinimumQuantityStock();

        if ($transaction['quantity'] < $minimumStock) {
            notify()->preset('error', [
                'title' => 'Minimum Quantity Not Reached',
                'message' => 'Stock Minimum Quantity is below than ' . $minimumStock
            ]);
            return redirect()->back()->with('error');
        }

        $this->stockTransactionService->createTransaction($transaction, $request->quantity);
        notify()->preset('user-created', [
            'title' => 'Transaction Created',
            'message' => 'Stock Transaction has been created successfully'
        ]);

        return redirect()->route('stock.transaction')->with('success');
    }

    public function stockConfirmation(Request $request, $id) {
        $validated = $request->validate([
            'status' => 'required|in:Diterima,Ditolak,Dikeluarkan',
        ]);
    
        $stock = $this->stockTransactionService->getTransactionByProduct($id);
        $stock->status = $validated['status'];
        $stock->save();
    
        notify()->preset('user-created', [
            'title' => 'Stock Data Updated',
            'message' => 'Stock Data has been updated successfully',
        ]);
        return redirect()->route('stock.observe')->with('success');
    }
    
    public function opnameData(Request $request) {
        $stockId = $request->input('stock_id');
        $types = $request->input('type');
        $status = $request->input('status');
        $quantity = $request->input('minimum_stock');

        foreach($stockId as $index => $id) {
            $data = array_filter([
                'type' => $types[$index] ?? null,
                'status' => $status[$index] ?? null,
                'quantity' => $quantity[$index] ?? null,
            ]);

            if(!empty($data)) {
                $this->stockTransactionService->updateTransaction($id, $data);
                notify()->preset('user-created', [
                    'title' => 'Stock Data Updated',
                    'message' => 'Stock Data has been updated successfully'
                ]);
            }
        }

        $redirectByAuth = auth()->user()->role;

        if($redirectByAuth === 'Admin') {
            return redirect()->route('stock.opname')->with('success');
        } elseif ($redirectByAuth === 'Manajer Gudang') {
            return redirect()->route('stock.manager-opname')->with('success');
        }
    }

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
