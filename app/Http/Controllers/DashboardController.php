<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function redirectTo()
    {
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

    public function index()
    {
        if (Auth::user()->role == 'Admin') {
            return view('roles.admin.index', [
                'title' => 'Dashboard Admin',
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
