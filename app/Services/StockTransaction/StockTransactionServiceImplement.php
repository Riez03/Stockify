<?php

namespace App\Services\StockTransaction;

use App\Models\Categories;
use Barryvdh\DomPDF\Facade\Pdf;
use LaravelEasyRepository\Service;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;

class StockTransactionServiceImplement extends Service implements StockTransactionService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;
  protected $categoryService;

  public function __construct(
    StockTransactionRepository $mainRepository,
    CategoryRepository $categoryRepository
  ) {
    $this->mainRepository = $mainRepository;
    $this->categoryService = $categoryRepository;
  }

  public function getAllStockTransaction()
  {
    return $this->mainRepository->all();
  }

  public function getTransactionByProduct($id)
  {
    return $this->mainRepository->find($id);
  }

  public function createTransaction($data)
  {
    return $this->mainRepository->create($data);
  }

  public function updateTransaction($id, $data)
  {
    return $this->mainRepository->update($id, $data);
  }

  public function deleteTransaction($id)
  {
    return $this->mainRepository->delete($id);
  }

  public function getAllCategoryByStock()
  {
    return $this->categoryService->all();
  }

  public function getTransactionByType($type)
  {
    return $this->mainRepository->filterByType($type);
  }

  public function getTransactionByCriteria($criteria)
  {
    return $this->mainRepository->filterByCriteria($criteria);
  }

  public function generatePdfByType($type)
  {
    $data = $this->mainRepository->filterByType($type);

    $typeLabel = match ($type) {
      'masuk' => 'Barang Masuk',
      'keluar' => 'Barang Keluar',
      default => 'Semua Transaksi',
    };

    return Pdf::loadView('reports.transactionReport', [
      'data' => $data,
      'title' => 'Laporan Transaksi Barang',
      'typeLabel' => $typeLabel,
    ])->stream("transaction-report.pdf");
  }

  public function generatePdfByCriteria($criteria)
  {
    $data = $this->mainRepository->filterByCriteria($criteria);
    $title = 'Laporan Transaksi Stock Barang';
    $filters = $criteria;

    if (isset($filters['categories'])) {
      $category = Categories::find($filters['categories']);
      if ($category) {
        $filters['categories_name'] = $category->name;
      }
    }

    return Pdf::loadView('reports.stockReport', compact('data', 'title', 'filters'))->stream("stock-report.pdf");
  }

  public function getMinimumQuantityStock()
  {
    return $this->mainRepository->getMinimumStock();
  }

  public function updateMinimumQuantityStock($minQuantity)
  {
    if ($minQuantity < 0) {
      throw new \InvalidArgumentException('Minimum stock must be greater than or equal to zero.');
    }
    $this->mainRepository->updateMinimumStock($minQuantity);
  }

  public function getTransactionByTypeAndPeriod($type, $days = 30) {
    return $this->mainRepository->countTransactionByTypeAndPeriod($type, $days);
  }
}
