<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function index()
    {
        $repairs = Repair::all();
        return view('admin.repairs.index', compact('repairs'));
    }

    public function create()
    {
        $rooms = Room::all();
        $devices = Device::all();
        $users = User::all();
        return view('admin.repairs.create', compact('rooms', 'devices', 'users'));
    }

    public function store(Request $request)
    {
        Repair::create($request->all());
        return redirect()->route('admin.repairs.index');
    }
}
