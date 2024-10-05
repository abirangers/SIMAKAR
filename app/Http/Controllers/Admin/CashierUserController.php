<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class CashierUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashiers = User::where('role', 'kasir')->get();
        return Inertia::render('Admin/Cashier/Index', compact('cashiers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Cashier/Manage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|in:kasir,admin',
        ]);

        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('cashier.index')->with('success', 'Kasir berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cashier = User::findOrFail($id);
        return Inertia::render('Admin/Cashier/Manage', compact('cashier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:kasir,admin',
        ]);

        $cashier = User::findOrFail($id);
        $cashier->update([
            'name' => $request->name,
            'password' => $request->password ? Hash::make($request->password) : $cashier->password,
            'role' => $request->role,
        ]);

        return redirect()->route('cashier.index')->with('success', 'Kasir berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cashier = User::findOrFail($id);
        $cashier->delete();

        return redirect()->route('cashier.index')->with('success', 'Kasir berhasil dihapus');
    }
}
