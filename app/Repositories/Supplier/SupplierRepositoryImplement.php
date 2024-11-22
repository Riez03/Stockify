<?php

namespace App\Repositories\Supplier;

use App\Models\Suppliers;
use App\Events\ModelActivity;
use LaravelEasyRepository\Implementations\Eloquent;

class SupplierRepositoryImplement extends Eloquent implements SupplierRepository {

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Suppliers $model) {
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
        $supplier = $this->model->create($data);

        event(new ModelActivity(
            auth()->user(), 
            'create', 
            'Supplier', 
            $supplier->name, 
            'Supplier has been created successfuly',
            $supplier->created_at,
        ));

        return $supplier;
    }

    public function update($id, $data) {
        $supplier = $this->find($id);
        $supplier->update($data);
        
        event(new ModelActivity(
            auth()->user(), 
            'update', 
            'Supplier', 
            $supplier->name, 
            'Supplier has been updated successfuly',
            $supplier->created_at,
        ));

        return $supplier;
    }

    public function delete($id) {
        $supplier = $this->find($id);
        
        event(new ModelActivity(
            auth()->user(), 
            'delete', 
            'Supplier', 
            $supplier->name, 
            'Supplier has been deleted successfuly',
            $supplier->created_at,
        ));

        return $supplier->delete();
    }
}
