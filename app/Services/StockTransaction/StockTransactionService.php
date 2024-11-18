<?php

namespace App\Services\StockTransaction;

use LaravelEasyRepository\BaseService;

interface StockTransactionService extends BaseService {
    public function getAllStockTransaction();
    public function getTransactionByProduct($id);
    public function createTransaction($data);
    public function updateTransaction($id, $data);
    public function deleteTransaction($id);
    public function getAllCategoryByStock();
    public function getTransactionByType($type);
    public function getTransactionByCriteria($criteria);
}
