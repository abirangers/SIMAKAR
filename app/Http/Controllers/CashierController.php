<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ambil category name nya aja
        $categories = Category::all();
        $query = Menu::with('category');

        if ($request->has('category') && $request->query('category') !== null) {
            $categoryName = $request->query('category');
            $query->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            });
        }

        $menus = $query->get();

        return Inertia::render('Kasir/Index', compact('categories', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'cash' => 'required|numeric|min:0',
            'cartItems' => 'required|array',
            'cartItems.*.id' => 'required|exists:menus,id',
            'cartItems.*.quantity' => 'required|integer|min:1',
        ]);

        if ($request->cash == 0) {
            return redirect()->back()->withErrors(['cash' => 'Uang yang diberikan tidak boleh 0.']);
        }

        if ($request->cash < $request->total) {
            return redirect()->back()->withErrors(['cash' => 'Uang yang diberikan kurang dari total belanjaan.']);
        }

        $order = Order::create([
            'order_code' => 'INV/' . date('YmdHis'),
            'user_id' => $request->user()->id,
            'customer_name' => $request->customer_name,
            'subtotal' => $request->subtotal,
            'tax' => $request->tax,
            'total' => $request->total,
            'cash' => $request->cash,
            'change' => $request->cash - $request->total,
            'status' => 'pending',
        ]);

        foreach ($request->cartItems as $item) {
            $order->orderItems()->create([
                'menu_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
            ]);
        }

        // update stock
        foreach ($request->cartItems as $item) {
            $menu = Menu::find($item['id']);
            $menu->stock -= $item['quantity'];
            $menu->save();
        }

        return redirect()->route('kasir.index')->with('success', 'Order created successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
