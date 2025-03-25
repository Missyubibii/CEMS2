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
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name', // Kiểm tra tên tài khoản trùng
            'role' => 'required|in:Admin,Giáo viên',
            'phone' => 'required|numeric|unique:users,phone', // Kiểm tra số điện thoại trùng
            'email' => 'required|email|max:255|unique:users,email', // Kiểm tra email trùng
            'password' => 'required|min:8|confirmed', // Mật khẩu mới phải trùng với mật khẩu xác nhận
        ], [
            'name.unique' => 'Tên tài khoản đã tồn tại.',
            'email.unique' => 'Địa chỉ email đã tồn tại.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'password.confirmed' => 'Mật khẩu mới và mật khẩu xác nhận không khớp.',
        ]);

        // Tạo tài khoản mới
        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);

        return redirect()->route('admin.users.index')->with('status', 'account-created');
    }

    public function edit(user $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'role' => 'required|in:Admin,Giáo viên',
            'phone' => 'required|numeric|unique:users,phone,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|current_password',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'name.unique' => 'Tên tài khoản đã tồn tại.',
            'email.unique' => 'Địa chỉ email đã tồn tại.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'password.confirmed' => 'Mật khẩu mới và mật khẩu xác nhận không khớp.',
            'current_password.current_password' => 'Mật khẩu cũ không đúng.',
        ]);

        // Kiểm tra mật khẩu cũ nếu có thay đổi mật khẩu
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu cũ không đúng.']);
            }
        }

        // Cập nhật thông tin tài khoản
        $user->update($request->only(['name', 'role', 'phone', 'email']));

        // Nếu có mật khẩu mới, tiến hành cập nhật
        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()->route('admin.users.edit', $user)->with('status', 'profile-updated');
    }

    public function destroy(user $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Tài khoản đã được xóa.');
    }
}
