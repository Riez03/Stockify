<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductAttributes;
use App\Services\ProductAttribute\ProductAttributeService;

class ProductAttributesController extends Controller
{
    protected $productAttributeService;

    public function __construct(ProductAttributeService $productAttributeService) {
        $this->productAttributeService = $productAttributeService;
    }

    private function validationData() {
        return [
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ];
    }

    public function index() {
        $productAttribute = $this->productAttributeService->getAllAttributeProducts();
        $products = $this->productAttributeService->getAllProducts();

        return view('roles.admin.product.attributes.index', [
            'title' => 'Product Attributes',
            'productAttribute' => $productAttribute,
            'product' => $products,
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate($this->validationData());

        $this->productAttributeService->createAttributeProduct($data);
        notify()->preset('user-created', [
            'title' => 'Attribute Product Created',
            'message' => 'Attribute Product has been created successfully'
        ]);
        return redirect()->route('attributes.index')->with('success', 'Product created successfully.');
    }

    public function show($id) {
        $productAttribute = $this->productAttributeService->getAttributeProduct($id);
        $attributeOnly = $this->productAttributeService->getAttributeProduct($id)::where('product_id', $id)->get();

        return view('roles.admin.product.attributes.attribute-detail', [
            'title' => 'Product Attribute Detail',
            'productAttribute' => $productAttribute,
            'attributes' => $attributeOnly,
        ]);
    }

    public function edit($id) {
        $productAttribute = $this->productAttributeService->getAttributeProduct($id);
        return view('roles.admin.product.attributes.edit-attribute', [
            'title' => 'Edit Attribute Product',
            'productAttribute' => $productAttribute,
        ]);
    }

    public function update(Request $request, $id) {
        $data = $request->validate($this->validationData());
        $this->productAttributeService->update($id, $data);

        notify()->preset('user-created', [
            'title' => 'Attribute Product Updated',
            'message' => 'Attribute Product has been updated successfully'
        ]);
        return redirect()->route('attributes.index')->with('success', 'Attribute Product updated successfully.');
    }

    public function destroy($id) {
        $this->productAttributeService->deleteAttributeProduct($id);

        notify()->preset('user-deleted', [
            'title' => 'Attribute Product Deleted',
            'message' => 'Attribute Product has been deleted successfully'
        ]);
        return redirect()->route('attributes.index');
    }
}
