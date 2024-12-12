<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        return view('admin.buildings.index', compact('buildings'));
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
            'building_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('buildings', 'building_name')->ignore($building->id),
            ],
        ], [
            'building_name.unique' => 'Tên tòa nhà đã tồn tại. Vui lòng nhập tên khác.',
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
