<?php

namespace App\Repositories\StockTransaction;

use Carbon\Carbon;
use App\Models\Categories;
use App\Models\StockTransactions;
use LaravelEasyRepository\Implementations\Eloquent;

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
        return $this->model->with(['products', 'users'])->simplePaginate(5);
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

    public function filterByType($type) {
        $query = $this->model->query();

        if($type) {
            $query->where('type', $type);
        }

        return $query->with(['products', 'users'])->simplePaginate(5);
    }

    public function filterByCriteria($criteria) {
        $query = $this->model->query();

        // By Period Date
        if(!empty($criteria['periods'])) {
            $startDate = now();
            $endDate = now();

            switch($criteria['periods']) {
                case '7 Days':
                    $startDate = now()->subDays(7);
                    break;
                case '30 Days':
                    $startDate = now()->subDays(30);
                    break;
                case '3 Month':
                    $startDate = now()->subMonths(3);
                    break;
                case 'custom':
                    if(!empty($criteria['start_date']) && !empty($criteria['end_date'])) {
                        $startDate = Carbon::parse($criteria['start_date'])->startOfDay();
                        $endDate = Carbon::parse($criteria['end_date'])->endOfDay();
                    } else {
                        $query->whereRaw('1 = 0');
                    }
                    break;
            }
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        // By Product Category
        if(!empty($criteria['categories'])) {
            $category = Categories::find($criteria['categories']);
            if($category) {
                $query->whereHas('products', function($query) use ($criteria) {
                    $query->where('category_id', $criteria['categories']);
                });
            }
        }

        return $query->with(['products', 'users'])->simplePaginate(5);
    }
}
