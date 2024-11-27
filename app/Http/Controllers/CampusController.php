<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::all();
        return view('admin.campuses.index', compact('campuses'));
    }

    public function create()
    {
        return view('admin.campuses.create');
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
            'campus_name' => 'required|string|max:255',
        ]);

        $campus->update([
            'campus_name' => $request->campus_name,
        ]);

        return redirect()->route('admin.campuses.index')->with('success', 'Cơ sở đã được cập nhật.');
    }

    public function destroy(Campus $campus)
    {
        $campus->delete();
        return redirect()->route('admin.campuses.index')->with('success', 'Cơ sở đã được xóa.');
    }
}

