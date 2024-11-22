<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Events\ModelActivity;
use LaravelEasyRepository\Implementations\Eloquent;

class UserRepositoryImplement extends Eloquent implements UserRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all() {
        return $this->model->simplePaginate(5);
    }

    public function find($id) {
        return $this->model->findOrFail($id);
    }

    public function create($data) {
        $user =  $this->model->create($data);
        
        event(new ModelActivity(
            auth()->user(), 
            'create', 
            'User', 
            $user->name, 
            'User has been created successfuly',
            $user->created_at,
        ));

        return $user;
    }

    public function update($id, $data) {
        $user = $this->model->find($id);
        $user->update($data);
        
        event(new ModelActivity(
            auth()->user(), 
            'update', 
            'User', 
            $user->name, 
            'User has been updated successfuly',
            $user->created_at,
        ));

        return $user;
    }

    public function delete($id) {
        $user = $this->model->find($id);
        
        event(new ModelActivity(
            auth()->user(), 
            'delete', 
            'User', 
            $user->name, 
            'User has been deleted successfuly',
            $user->created_at,
        ));

        return $user->delete();
    }
}
