<?php

namespace App\Repositories\Product;

use App\Events\ModelActivity;
use App\Models\Products;
use BladeUIKit\Components\DateTime\Carbon;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductRepositoryImplement extends Eloquent implements ProductRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Products $model) {
        $this->model = $model;
    }

    public function all() {
        return $this->model->all();
    }

    public function withRelation()
    {
        return $this->model->with(['categories', 'suppliers'])->simplePaginate(5);
    }

    public function find($id) {
        return $this->model->findOrFail($id);
    }

    public function create($data) {
        $product = $this->model->create($data);

        event(new ModelActivity(
            auth()->user(), 
            'create', 
            'Products', 
            $product->name, 
            'Product has been created successfuly',
            $product->created_at,
        ));
        
        return $product;
    }

    public function update($id, $data) {
        $product = $this->model->find($id);
        $product->update($data);

        event(new ModelActivity(
            auth()->user(), 
            'update', 
            'Products', 
            $product->name, 
            'Product has been updated successfuly',
            $product->created_at,
        ));

        return $product;
    }

    public function delete($id) {
        $product = $this->model->find($id);
        
        event(new ModelActivity(
            auth()->user(), 
            'delete', 
            'Products', 
            $product->name, 
            'Product has been deleted successfuly',
            $product->created_at,
        ));

        return $product->delete();
    }
}
