<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = user::all();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric',
            'role' => 'required|in:Admin,Giáo viên',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => Hash::make('password123'), // Mặc định gán mật khẩu
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Tài khoản đã được thêm thành công!');
    }


    /**
     * Hiển thị form chỉnh sửa thiết bị.
     */
    public function edit(user $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin thiết bị.
     */
    public function update(Request $request, user $user)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:Admin,Giáo viên',
            'phone' => 'required|integer|min:10|max:12',
            'email' => 'required|string|max:255',
        ]);

        // Cập nhật thiết bị
        $user->update([
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);

        // Chuyển hướng về trang quản lý thiết bị với thông báo thành công
        return redirect()->route('admin.users.index')->with('status', 'Đã chỉnh sửa thông tin tài khoản');
    }


    public function destroy(user $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Tài khoản đã được xóa.');
    }
}
