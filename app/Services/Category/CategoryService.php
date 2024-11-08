<?php

namespace App\Services\Category;

use LaravelEasyRepository\BaseService;

interface CategoryService extends BaseService
{
    public function getAllCategories();

    public function getCategory($id);

    public function createCategory($data);

    public function updateCategory($id, $data);

    public function deleteCategory($id);
}
