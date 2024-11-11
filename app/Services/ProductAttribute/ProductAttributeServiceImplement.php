<?php

namespace App\Services\ProductAttribute;

use App\Repositories\Product\ProductRepository;
use LaravelEasyRepository\Service;
use App\Repositories\ProductAttribute\ProductAttributeRepository;

class ProductAttributeServiceImplement extends Service implements ProductAttributeService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;
  protected $productRepository;

  public function __construct(
    ProductAttributeRepository $mainRepository,
    ProductRepository $productRepository
  ) {
    $this->mainRepository = $mainRepository;
    $this->productRepository = $productRepository;
  }

  public function getAllAttributeProducts()
  {
    return $this->mainRepository->all();
  }

  public function getAttributeProduct($id)
  {
    return $this->mainRepository->find($id);
  }

  public function createAttributeProduct($data)
  {
    return $this->mainRepository->create($data);
  }

  public function updateAttributeProduct($id, $data)
  {
    return $this->mainRepository->update($id, $data);
  }

  public function deleteAttributeProduct($id)
  {
    return $this->mainRepository->delete($id);
  }

  public function getAllProducts() {
    return $this->productRepository->all();
  }
}
