<?php

namespace App\Repositories\Category;

use App\Models\Categories;
use App\Events\ModelActivity;
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
        $category = $this->model->create($data);

        event(new ModelActivity(
            auth()->user(), 
            'create', 
            'Categories', 
            $category->name, 
            'Categories has been created successfuly',
            $category->created_at,
        ));

        return $category;
    }

    public function update($id, $data) {
        $category = $this->find($id);
        $category->update($data);

        event(new ModelActivity(
            auth()->user(), 
            'update', 
            'Categories', 
            $category->name, 
            'Categories has been updated successfuly',
            $category->created_at,
        ));

        return $category;
    }

    public function delete($id) {
        $category = $this->find($id);
        
        event(new ModelActivity(
            auth()->user(), 
            'delete', 
            'Categories', 
            $category->name, 
            'Categories has been deleted successfuly',
            $category->created_at,
        ));

        return $category->delete();
    }
}
