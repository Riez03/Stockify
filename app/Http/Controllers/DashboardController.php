<?php

namespace App\Http\Controllers;

use App\Services\Product\ProductService;
use App\Services\StockTransaction\StockTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    protected $productService, $stockTransactionService;

    public function __construct(
        ProductService $productService,
        StockTransactionService $stockTransactionService,
    ) {
        $this->productService = $productService;
        $this->stockTransactionService = $stockTransactionService;
    }

    public function redirectTo() {
        if (Auth::check()) {
            if (Auth::user()->role == 'Admin') {
                return redirect('admin/dashboard');
            } elseif (Auth::user()->role == "Staff Gudang") {
                return redirect('staff/dashboard');
            } elseif (Auth::user()->role == "Manajer Gudang") {
                return redirect('manajer/dashboard');
            }
        }

        return redirect(route('login'));
    }

    public function index() {
        $getAllProducts = $this->productService->getAllProducts();

        $getAllStock = $this->stockTransactionService->getAllStockTransaction();
        $MinQuantity = $this->stockTransactionService->getMinimumQuantityStock();

        $totalLowStock = $getAllStock->filter(function ($stock) use ($MinQuantity) {
            return $stock->quantity < $MinQuantity; 
        })->count();

        $filePath = public_path('data/userActivities.json');
        $activities = [];

        if (File::exists($filePath)) {
            $decodedData = json_decode(File::get($filePath), true);

            if (!is_array($decodedData)) {
                $activities = [$decodedData];
            } elseif(isset($decodedData[0])) {
                $activities = $decodedData;
            } else {
                $activities = [$decodedData];
            }
        }

        if (Auth::user()->role == 'Admin') {
            return view('roles.admin.index', [
                'title' => 'Dashboard Admin',
                'activities' => $activities,
                'totalProducts' => count($getAllProducts),
                'totalLowStock' => $totalLowStock,
            ]);
        } elseif (Auth::user()->role == "Staff Gudang") {
            return view('roles.staff.index', [
                'title' => 'Dashboard Staff Gudang',
            ]);
        } elseif (Auth::user()->role == "Manajer Gudang") {
            return view('', [
                'title' => 'Dashboard Manajer Gudang'
            ]);
        }
    }
}
