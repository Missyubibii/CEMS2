<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::all();
        return view('admin.campuses.index', compact('campuses'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'campus_name' => 'required|string|max:255',
        ]);

        Campus::create([
            'campus_name' => $request->campus_name,
        ]);

        return redirect()->route('admin.campuses.index')->with('success', 'Cơ sở đã được thêm.');
    }

    public function edit(Campus $campus)
    {
        return view('admin.campuses.edit', compact('campus'));
    }

    public function update(Request $request, Campus $campus)
    {
        $request->validate([
            'campus_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('campuses', 'campus_name')->ignore($campus->id),
            ],
        ], [
            'campus_name.unique' => 'Tên cơ sở học đã tồn tại. Vui lòng nhập tên khác.',
        ]);

        // Cập nhật cơ sở học
        $campus->update([
            'campus_name' => $request->campus_name,
        ]);

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('admin.campuses.index')->with('success', 'Cơ sở học đã được cập nhật.');
    }


    public function destroy(Campus $campus)
    {
        $campus->delete();
        return redirect()->route('admin.campuses.index')->with('success', 'Cơ sở đã được xóa.');
    }
}

