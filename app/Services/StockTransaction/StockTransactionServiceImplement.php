<?php

namespace App\Services\StockTransaction;

use LaravelEasyRepository\Service;
use App\Repositories\StockTransaction\StockTransactionRepository;

class StockTransactionServiceImplement extends Service implements StockTransactionService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(StockTransactionRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function getAllStockTransaction() {
      return $this->mainRepository->all();
    }

    public function getTransactionByProduct($id) {
      return $this->mainRepository->find($id);
    }

    public function createTransaction($data) {
      return $this->mainRepository->create($data);
    }

    public function updateTransaction($id, $data) {
      return $this->mainRepository->update($id, $data);
    }

    public function deleteTransaction($id) {
      return $this->mainRepository->delete($id);
    }
    
    public function getStockTransactionByDateRange($startDate, $endDate) {
      if($startDate && $endDate) {
        return $this->mainRepository->getByDateRange($startDate, $endDate);
      }
    }
}
