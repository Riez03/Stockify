<?php

namespace App\Repositories\ProductAttribute;

use App\Events\ModelActivity;
use App\Models\ProductAttribute;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductAttributeRepositoryImplement extends Eloquent implements ProductAttributeRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(ProductAttribute $model)
    {
        $this->model = $model;
    }

    public function all() {
        return $this->model->with('products')->simplePaginate(5);
    }

    public function find($id) {
        return $this->model->findOrFail($id);
    }

    public function create($data) {
        $attribute = $this->model->create($data);

        event(new ModelActivity(
            auth()->user(), 
            'create', 
            'Product_Attributes', 
            $attribute->name, 
            'Product attribute has been created successfuly',
            $attribute->created_at,
        ));

        return $attribute;
    }

    public function update($id, $data) {
        $attributeProduct = $this->model->find($id);
        $attributeProduct->update($data);

        event(new ModelActivity(
            auth()->user(), 
            'update', 
            'Product_Attributes', 
            $attributeProduct->name, 
            'Product attribute has been updated successfuly',
            $attributeProduct->created_at,
        ));

        return $attributeProduct;
    }

    public function delete($id) {
        $attribute = $this->model->find($id);

        event(new ModelActivity(
            auth()->user(), 
            'delete', 
            'Product_Attributes', 
            $attribute->name, 
            'Product attribute has been deleted successfuly',
            $attribute->created_at,
        ));

        return $attribute->delete();
    }
}
