<?php

namespace App\Http\Controllers;

use App\Services\Product\ProductService;
use App\Services\StockTransaction\StockTransactionService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    protected $productService, $stockTransactionService, $userService;

    public function __construct(
        ProductService $productService,
        StockTransactionService $stockTransactionService,
        UserService $userService,
    ) {
        $this->productService = $productService;
        $this->stockTransactionService = $stockTransactionService;
        $this->userService = $userService;
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

    public function downloadUserActivityReport(Request $request) {
        $request->input('action', 'view');
        return $this->userService->generateActivityReport();
    }

    public function index() {
        $getAllProducts = $this->productService->getAllProducts();
        $activitiesUser = $this->userService->getAllUserActivities();
        $transactionLastSixMonth = $this->stockTransactionService->getTransactionByMonthAndYear();

        $getAllStock = $this->stockTransactionService->getAllStockTransaction();
        $MinQuantity = $this->stockTransactionService->getMinimumQuantityStock();

        $totalIncomingTransaction = $this->stockTransactionService->getTransactionByTypeAndPeriod('Masuk', 30);
        $totalOutgoingTransaction = $this->stockTransactionService->getTransactionByTypeAndPeriod('Keluar', 30);

        $totalLowStock = $getAllStock->filter(function ($stock) use ($MinQuantity) {
            return $stock->quantity < $MinQuantity || $stock->quantity == $MinQuantity; 
        })->count();

        if (Auth::user()->role == 'Admin') {
            return view('roles.admin.index', [
                'title' => 'Dashboard Admin',
                'activities' => $activitiesUser,
                'totalProducts' => count($getAllProducts),
                'totalLowStock' => $totalLowStock,
                'incomingTransaction' => $totalIncomingTransaction,
                'outgoingTransaction' => $totalOutgoingTransaction,
                'transactionData' => $transactionLastSixMonth,
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
