<?php

namespace App\Repositories\StockTransaction;

use LaravelEasyRepository\Repository;

interface StockTransactionRepository extends Repository {
    public function all();
    public function find($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function getByDateRange($startDate, $endDate);
}
