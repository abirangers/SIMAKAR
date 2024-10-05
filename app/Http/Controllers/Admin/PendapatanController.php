<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class PendapatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.menu'])->get();
        return Inertia::render('Admin/Pendapatan/Index', compact('orders'));
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
        //
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
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('pendapatan.index')->with('success', 'Pendapatan berhasil dihapus');
    }

    /**
     * Generate a PDF version of the order.
     */
    public function cetakOrder(string $id)
    {
        $order = Order::with(['user', 'orderItems.menu'])->findOrFail($id);
        
        $pdf = Pdf::loadView('admin.pendapatan.print', compact('order'));
        
        // Sanitize the filename
        $filename = 'order-' . preg_replace('/[^A-Za-z0-9\-]/', '', $order->order_code) . '.pdf';
        
        return $pdf->stream($filename);
    }
}
