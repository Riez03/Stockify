<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
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
            'quantity' => 'required|integer',
            'date' => 'nullable|date',
            'status' => 'required|in:Pending,Diterima,Ditolak,Dikeluarkan',
            'notes' => 'nullable|string',
        ];
    }

    public function index() {
        $transaction = $this->stockTransactionService->getAllStockTransaction();

        return view('roles.admin.transaction.index', [
            'title' => 'History Stock Transaction',
            'transaction' => $transaction,
        ]);
    }

    public function store(Request $request) {
        $transaction = $request->validate($this->transactionValidation());

        $this->stockTransactionService->createTransaction($transaction);

        notify()->preset('user-created', [
            'title' => 'Transaction Created',
            'message' => 'Stock Transaction has been created successfully'
        ]);

        return redirect()->route('transaction.index')->with('success', 'Stock Transaction created successfully.');
    }

    public function show($id) {

    }

    public function edit($id) {

    }

    public function update($id, $data) {

    }

    public function performStockOpname($productId, $actualQty) {
        $transaction = $this->stockTransactionService->find($productId);
        $difference = $actualQty - $transaction->quantity;

        $transactionType = $difference > 0 ? 'Masuk' : 'Keluar';
        $this->stockTransactionService->createTransaction([
            'product_id' => $productId,
            'type' => $transactionType,
            'quantity' => abs($difference),
            'status' => 'Diterima',
            'notes' => 'Stock Opname Adjustment'
        ]);

        $transaction->quantity = $actualQty;
        $transaction->save();
    }
}
