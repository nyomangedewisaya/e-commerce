<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);
        $allowedSortBy = ['amount', 'created_at'];
        $allowedSortDir = ['asc', 'desc'];
        $sortBy = in_array($request->input('sort_by'), $allowedSortBy) ? $request->input('sort_by') : 'created_at';
        $sortDir = in_array($request->input('sort_dir'), $allowedSortDir) ? $request->input('sort_dir') : 'desc';
        $query = Payment::with('order');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('invoice', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->whereHas('order', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        if ($request->filled('method')) {
            $method = $request->input('method'); 
            $query->where('method', $method);
        }
        
        $query->orderBy($sortBy, $sortDir);

        $payments = $query->paginate($perPage)->withQueryString();

        return view('admin.payments', compact('payments'));
    }
}
