<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    private function userValidation($id = null) {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => $id ? 'nullable|string|min:8' : 'required|string|min:8',
            'role' => 'required|in:Admin,Staff Gudang,Manajer Gudang',
        ];
    }

    public function index() {
        $user = $this->userService->getAllUser();
        return view('roles.admin.user.index', [
            'title' => 'User Management',
            'users' => $user,
        ]);
    }
    
    public function store(Request $request) {
        $data = $request->validate($this->userValidation());
        $validatedData['password'] = Hash::make($data['password']);

        $this->userService->createUser($data);
        notify()->preset('user-created', [
            'title' => 'User Created',
            'message' => 'User has been created successfully'
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show($id) {
        $user = $this->userService->getUserById($id);
        return view('roles.admin.user.detail', [
            'title' => 'User Detail',
            'user' => $user,
        ]);
    }

    public function edit($id) {
        $user = $this->userService->getUserById($id);
        return view('roles.admin.user.user-edit', [
            'title' => 'User Edit',
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate($this->userValidation($id));

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user = $this->userService->getUserById($id);
        $user->role = $validatedData['role'];

        $this->userService->updateUser($id, $validatedData);
        notify()->preset('user-created', [
            'title' => 'User Updated',
            'message' => 'User has been updated successfully'
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id) {
        $this->userService->deleteUser($id);
        notify()->preset('user-deleted', [
            'title' => 'User Deleted',
            'message' => 'User has been deleted successfully'
        ]);

        return redirect()->route('users.index');
    }
}
