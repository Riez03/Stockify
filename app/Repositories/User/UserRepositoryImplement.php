<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Events\ModelActivity;
use Illuminate\Support\Facades\File;
use LaravelEasyRepository\Implementations\Eloquent;

class UserRepositoryImplement extends Eloquent implements UserRepository {

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;
    protected $filePath;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->filePath = public_path('data/userActivities.json');
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

    public function userActivities() {
        if (!File::exists($this->filePath)) {
            return [];
        }

        $data = File::get($this->filePath);
        $decodedData = json_decode($data, true);

        if (!is_array($decodedData)) {
            $activities = [$decodedData];
        } elseif(isset($decodedData[0])) {
            $activities = $decodedData;
        } else {
            $activities = [$decodedData];
        }

        usort($activities, function($param1, $param2) {
            return strtotime($param2['timestamp']) - strtotime($param1['timestamp']);
        });

        return is_array($activities) ? $activities : [];
    }
}
