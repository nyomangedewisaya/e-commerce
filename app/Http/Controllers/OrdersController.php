<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrdersController extends Controller
{
    public function index(Request $request) {
        $perPage = (int) $request->input('per_page', 10);
        $allowedSortBy = ['amount', 'created_at'];
        $allowedSortDir = ['asc', 'desc'];
        $sortBy = in_array($request->input('sort_by'), $allowedSortBy) ? $request->input('sort_by') : 'created_at';
        $sortDir = in_array($request->input('sort_dir'), $allowedSortDir) ? $request->input('sort_dir') : 'desc';
        $query = Order::with(['user', 'payment', 'orderItems.product']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('order_code', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        if ($request->filled('method')) {
            $method = $request->input('method'); 
            $query->whereHas('payment', function ($q) use ($method) {
                $q->where('method', $method);
            });
        }
        
        $query->orderBy($sortBy, $sortDir);

        $orders = $query->paginate($perPage)->withQueryString();

        return view('admin.managements.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['success', 'pending', 'cancelled', 'failed'])]
        ]);
        
        $newStatus = $validated['status'];
        $originalStatus = $order->status;

        if ($newStatus == $originalStatus) {
            return redirect()->back();
        }
        try {
            DB::transaction(function () use ($order, $newStatus, $originalStatus) {
                $order->update(['status' => $newStatus]);
                if (in_array($newStatus, ['cancelled', 'failed']) && !in_array($originalStatus, ['cancelled', 'failed'])) {
                    foreach ($order->orderItems as $item) {
                        Product::find($item->product_id)->increment('stock', $item->quantity);
                    }
                }
            });

            return redirect()->back()->with('success', 'Status untuk order ' . $order->order_code . ' berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status.');
        }
    }

    public function cancelByUser(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Akses Ditolak');
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan ini tidak bisa dibatalkan.');
        }

        try {
            DB::transaction(function () use ($order) {
                $order->update(['status' => 'cancelled']);
                foreach ($order->orderItems as $item) {
                    Product::find($item->product_id)->increment('stock', $item->quantity);
                }
            });

            return back()->with('success', 'Pesanan berhasil dibatalkan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membatalkan pesanan.');
        }
    }
}
