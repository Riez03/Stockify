<?php

namespace App\Repositories\StockTransaction;

use Carbon\Carbon;
use App\Models\Categories;
use App\Events\ModelActivity;
use App\Models\StockTransactions;
use Illuminate\Support\Facades\Artisan;
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

    public function allNoPaginate() {
        return $this->model->with(['products', 'users'])->get();
    }

    public function find($id) {
        return $this->model->findOrFail($id);
    }

    public function create($data) {
        $stock = $this->model->create($data);

        event(new ModelActivity(
            auth()->user(), 
            'create', 
            'Stock_Transaction', 
            $stock->products->name, 
            `Stock Product with Type "$stock->type" created successfuly`,
            $stock->created_at,
        ));

        return $stock;
    }

    public function update($id, $data) {
        $transaction = $this->model->find($id);
        $originalData = $transaction->toArray();

        $transaction->update($data);
        $updatedData = $transaction->toArray();

        $changes = array_diff_assoc($updatedData, $originalData);

        if(!empty($changes)) {
            event(new ModelActivity(
                auth()->user(), 
                'update', 
                'Stock_Transaction', 
                $transaction->products->name, 
                "Stock Product with Type $transaction->type updated successful",
                $transaction->created_at,
            ));
        }

        return $transaction;
    }
    
    public function delete($id) {
        $transaction = $this->model->find($id);

        event(new ModelActivity(
            auth()->user(), 
            'delete', 
            'Stock_Transaction', 
            $transaction->products->name, 
            `Stock Product with Type "$transaction->type" deleted successfuly`,
            $transaction->created_at,
        ));

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
            $startDate = null;
            $endDate = null;

            switch($criteria['periods']) {
                case '7 Days':
                    $startDate = now()->subDays(7);
                    $endDate = now();
                    break;
                case '30 Days':
                    $startDate = now()->subDays(30);
                    $endDate = now();
                    break;
                case '3 Month':
                    $startDate = now()->subMonths(3);
                    $endDate = now();
                    break;
                case 'custom':
                    if(!empty($criteria['start_date']) && !empty($criteria['end_date'])) {
                        $startDate = Carbon::parse($criteria['start_date'])->startOfDay();
                        $endDate = Carbon::parse($criteria['end_date'])->endOfDay();
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

    public function getMinimumStock() {
        return config('stock.minimum_stock');
    }

    public function updateMinimumStock($minQuantity) {
        $path = config_path('stock.php');
        $content = file_get_contents($path);

        $replaceContent = preg_replace(
            "/'minimum_stock' => (\d+)/",
            "'minimum_stock' => {$minQuantity}",
            $content
        );

        file_put_contents($path, $replaceContent);

        Artisan::call('config:clear');
        Artisan::call('config:cache');
    }

    public function countTransactionByTypeAndPeriod($type, $days = 30) {
        $startDate = now()->subDays($days)->startOfDay();
        $endDate = now()->endOfDay();

        return $this->model
            ->where('type', $type)
            ->whereBetween('date', [$startDate, $endDate])
            ->count();
    }

    public function transactionByMonthAndYear($type) {
        $record = $this->model->selectRaw('MONTH(date) as month, YEAR(DATE) as year, SUM(quantity) as total_quantity')
            ->where('type', $type)
            ->groupBy('month', 'year')
            ->orderByRaw('year, month')
            ->get();

        return $record;
    }
}
