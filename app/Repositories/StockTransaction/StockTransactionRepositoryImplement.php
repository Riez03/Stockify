<?php

namespace App\Repositories\StockTransaction;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\StockTransactions;

class StockTransactionRepositoryImplement extends Eloquent implements StockTransactionRepository {

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(StockTransactions $model)
    {
        return $this->model = $model;
    }

    public function all() {
        return $this->model->with(['products', 'users'])->get();
    }

    public function find($id) {
        return $this->model->findOrFail($id);
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function update($id, $data) {
        $transaction = $this->model->find($id);
        $transaction->update($data);
        return $transaction;
    }
    
    public function delete($id) {
        $transaction = $this->model->find($id);
        return $transaction->delete();
    }

    public function getByDateRange($startDate, $endDate) {
        return $this->model->whereBetween('date', [$startDate, $endDate])->get();
    }
}
