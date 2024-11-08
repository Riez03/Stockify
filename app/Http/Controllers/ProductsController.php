<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Suppliers;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    private function validationRules() {
        return [
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|min:8|unique:products,sku,' . request()->route('product'),
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function index() {
        $products = $this->productService->getAllProducts();
        $category = $this->productService->getAllCategories();
        $supplier = $this->productService->getAllSuppliers();

        return view('roles.admin.product.index', [
            'title' => 'Products Management',
            'products' => $products,
            'category' => $category,
            'supplier' => $supplier,
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate($this->validationRules());

        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productService->createProduct($data);
        notify()->preset('user-created', [
            'title' => 'Product Created',
            'message' => 'Product has been created successfully'
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show($id) {
        $products = $this->productService->getProduct($id);
        return view('roles.admin.product.product-detail', [
            'title' => 'Product Detail',
            'product' => $products,
        ]);
    }

    public function edit($id) {
        $products = $this->productService->getProduct($id);
        $category = $this->productService->getAllCategories();
        $supplier = $this->productService->getAllSuppliers();

        return view('roles.admin.product.edit-product', [
            'title' => 'Edit Product',
            'product' => $products,
            'category' => $category,
            'supplier' => $supplier,
        ]);
    }

    public function update(Request $request, $id) {
        $data = $request->validate($this->validationRules());

        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productService->updateProduct($id, $data);
        notify()->preset('user-created', [
            'title' => 'Product Updated',
            'message' => 'Product has been updated successfully'
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id) {
        $this->productService->deleteProduct($id);
        notify()->preset('user-deleted', [
            'title' => 'Product Deleted',
            'message' => 'Product has been deleted successfully'
        ]);
        
        return redirect()->route('products.index');
    }
}