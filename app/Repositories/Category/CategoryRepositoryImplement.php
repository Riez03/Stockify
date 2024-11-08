<?php

namespace App\Repositories\Category;

use App\Models\Categories;
use LaravelEasyRepository\Implementations\Eloquent;

class CategoryRepositoryImplement extends Eloquent implements CategoryRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Categories $model)
    {
        $this->model = $model;
    }

    public function all() {
        return $this->model->all();
    }

    public function pagination() {
        return $this->model->simplePaginate(5);
    }

    public function find($id) {
        return $this->model->findOrFail($id);
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function update($id, $data) {
        $supplier = $this->find($id);
        $supplier->update($data);
        return $supplier;
    }

    public function delete($id) {
        $supplier = $this->find($id);
        $supplier->delete();
        return $supplier;
    }
}
