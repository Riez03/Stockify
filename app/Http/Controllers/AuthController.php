<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Setting\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService) {
        $this->settingService = $settingService;
    }

    public function index() {
        $appData = $this->settingService->getSetting();
        
        return view('authentication.sign-in', [
            'title' => 'Login',
            'setApp' => $appData,    
        ]);
    }

    public function registerView()
    {
        return view('authentication.sign-up', [
            'title' => 'Register',
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!empty(Auth::attempt($credentials))) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'Admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role == 'Manajer Gudang') {
                return redirect()->route('manajer.dashboard');
            } elseif (Auth::user()->role == 'Staff Gudang') {
                return redirect()->route('staff.dashboard');
            }
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
            ], 201);
        } else {
            return redirect()->route('auth.login')->with('success', 'User registered successfully, please login.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
