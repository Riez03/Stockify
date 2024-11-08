<?php

namespace App\Http\Controllers;

use App\Services\Category\CategoryService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function index() {
        $categories = $this->categoryService->getAllCategories();
        return view('roles.admin.category.index', [
            'title' => 'Category Management',
            'category' => $categories,
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->categoryService->createCategory($data);
        notify()->preset('user-created', [
            'title' => 'Category Created',
            'message' => 'Category has been created successfully'
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show($id) {
        $categories = $this->categoryService->getCategory($id);
        return view('roles.admin.category.categories-edit', [
            'title' => 'Detail Category',
            'category' => $categories,
        ]);
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->categoryService->updateCategory($id, $data);
        notify()->preset('user-updated', [
            'title' => 'Category Updated',
            'message' => 'Category data has been updated successfully'
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
    
    public function destroy($id) {
        $this->categoryService->deleteCategory($id);
        notify()->preset('user-deleted', [
            'title' => 'Category Deleted',
            'message' => 'Category data has been deleted successfully'
        ]);

        return redirect()->route('categories.index')->with('Success', 'Category delete successfully');
    }
}
