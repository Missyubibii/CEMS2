<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        return view('admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('admin.buildings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_name' => 'required|string|max:255',
        ]);

        Building::create([
            'building_name' => $request->building_name,
        ]);

        return redirect()->route('admin.buildings.index')->with('success', 'Tòa nhà đã được thêm.');
    }

    public function edit(Building $building)
    {
        return view('admin.buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        $request->validate([
            'building_name' => 'required|string|max:255',
        ]);

        $building->update([
            'building_name' => $request->building_name,
        ]);

        return redirect()->route('admin.buildings.index')->with('success', 'Tòa nhà đã được cập nhật.');
    }

    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('admin.buildings.index')->with('success', 'Tòa nhà đã được xóa.');
    }
}
