<?php

namespace App\Services\ProductAttribute;

use LaravelEasyRepository\Service;
use App\Repositories\ProductAttribute\ProductAttributeRepository;

class ProductAttributeServiceImplement extends Service implements ProductAttributeService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(ProductAttributeRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
