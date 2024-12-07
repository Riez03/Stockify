<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Supplier\SupplierService;

class SuppliersController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index() {
        $suppliers = $this->supplierService->getAllSuppliers();
        return view('roles.admin.supplier.index', [
            'title' => 'Supplier Management',
            'suppliers' => $suppliers,
        ]);
    }

    public function managerView() {
        $suppliers = $this->supplierService->getAllSuppliers();
        return view('roles.manager.supplier.index', [
            'title' => 'Supplier Management',
            'suppliers' => $suppliers,
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email',
        ]);

        $this->supplierService->createSupplier($data);
        notify()->preset('user-created', ['message' => 'Supplier has been created successfully']);

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function show($id) {
        $supplier = $this->supplierService->getSupplier($id);
        return view('roles.admin.supplier.detail-supplier', [
            'title' => 'Detail Supplier',
            'suppliers' => $supplier,
        ]);
    }

    public function edit($id) {
        $supplier = $this->supplierService->getSupplier($id);
        return view('roles.admin.supplier.edit-view', [
            'title' => 'Edit Supplier',
            'suppliers' => $supplier,
        ]);
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email',
        ]);

        $this->supplierService->updateSupplier($id, $data);
        notify()->preset('user-updated', ['message' => 'Supplier data has been updated successfully']);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }
    
    public function destroy($id) {
        $this->supplierService->deleteSupplier($id);
        notify()->preset('user-deleted', ['message' => 'Supplier data has been deleted successfully']);

        return redirect()->route('suppliers.index')->with('Success', 'Supplier delete successfully');
    }
}
