<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
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
        $filePath = public_path('data/userActivities.json');
        $activities = [];

        if (File::exists($filePath)) {
            $activities = json_decode(File::get($filePath), true);

            if (!is_array($activities)) {
                $activities = [$activities];
            }
        }

        if (Auth::user()->role == 'Admin') {
            return view('roles.admin.index', [
                'title' => 'Dashboard Admin',
                'activities' => $activities,
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
