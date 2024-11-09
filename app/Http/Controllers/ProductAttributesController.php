<?php

namespace App\Http\Controllers;

use App\Services\ProductAttribute\ProductAttributeService;
use Illuminate\Http\Request;

class ProductAttributesController extends Controller
{
    protected $productAttributeService;

    public function __construct(ProductAttributeService $productAttributeService) {
        $this->productAttributeService = $productAttributeService;
    }

    public function index() {
        $productAttribute = $this->productAttributeService->all();

        return view('', [
            'title' => 'Product Attributes',
            'productAttribute' => $productAttribute,
        ]);
    }
}
