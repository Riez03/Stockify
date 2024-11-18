<?php

namespace App\Services\StockTransaction;

use App\Repositories\Category\CategoryRepository;
use LaravelEasyRepository\Service;
use App\Repositories\StockTransaction\StockTransactionRepository;

class StockTransactionServiceImplement extends Service implements StockTransactionService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;
     protected $categoryService;

    public function __construct(
      StockTransactionRepository $mainRepository,
      CategoryRepository $categoryRepository
      )
    {
      $this->mainRepository = $mainRepository;
      $this->categoryService = $categoryRepository;
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

    public function getAllCategoryByStock() {
      return $this->categoryService->all();
    }

    public function getTransactionByType($type) {
      return $this->mainRepository->filterByType($type);
    }

    public function getTransactionByCriteria($criteria) {
      return $this->mainRepository->filterByCriteria($criteria);
    }
}
