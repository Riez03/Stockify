<?php

namespace App\Services\Product;

use App\Repositories\Category\CategoryRepository;
use LaravelEasyRepository\Service;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Supplier\SupplierRepository;

class ProductServiceImplement extends Service implements ProductService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;
     protected $categoryRepository;
     protected $supplierRepository;

    public function __construct(
      ProductRepository $mainRepository,
      CategoryRepository $categoryRepository,
      SupplierRepository $supplierRepository
      ) {
      $this->mainRepository = $mainRepository;
      $this->categoryRepository = $categoryRepository;
      $this->supplierRepository = $supplierRepository;
    }

    public function getAllProducts() {
      return $this->mainRepository->withRelation();
    }

    public function getProduct($id) {
      return $this->mainRepository->find($id);
    }

    public function createProduct($data) {
      return $this->mainRepository->create($data);
    }

    public function updateProduct($id, $data) {
      return $this->mainRepository->update($id, $data);
    }

    public function deleteProduct($id) {
      return $this->mainRepository->delete($id);
    }

    public function getAllCategories() {
      return $this->categoryRepository->all();
    }

    public function getAllSuppliers() {
      return $this->supplierRepository->all();
    }
}
