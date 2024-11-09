<?php

namespace App\Repositories\ProductAttribute;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\ProductAttributes;

class ProductAttributeRepositoryImplement extends Eloquent implements ProductAttributeRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(ProductAttributes $model)
    {
        $this->model = $model;
    }

    public function all() {
        return $this->model->with('products');
    }

    public function find($id) {
        return $this->model->findOrFail($id);
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function update($id, $data) {
        $attributeProduct = $this->model->find($id);
        $attributeProduct->update($data);
        return $attributeProduct;
    }

    public function delete($id) {
        $product = $this->model->find($id);
        return $product->delete();
    }
}
