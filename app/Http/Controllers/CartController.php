<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        $cartItems = collect();
        $total = 0;

        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'];
            $cartItems->push([
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity,
            ]);
            $total += $product->price * $quantity;
        }

        return view('cart', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        $currentQuantitiyInCart = $cart[$product->id]['quantity'] ?? 0;
        if ($product->stock < $currentQuantitiyInCart + $request->quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = ['quantity' => $request->quantity];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $productId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if ($product->stock < $request->quantity) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Stok produk tidak mencukupi.'], 422);
            }
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        if ($request->wantsJson()) {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get();
            $newTotal = 0;
            foreach ($products as $p) {
                $newTotal += $p->price * $cart[$p->id]['quantity'];
            }
            return response()->json([
                'message' => 'Keranjang berhasil diperbarui!',
                'new_total' => $newTotal,
                'new_subtotal' => $product->price * $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        $newTotal = 0;
        foreach ($products as $p) {
            $newTotal += $p->price * $cart[$p->id]['quantity'];
        }

        return response()->json([
            'message' => 'Produk berhasil dihapus!',
            'new_total' => $newTotal,
        ]);
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,e-wallet,credit_card',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $order = null;
        try {
            DB::transaction(function () use ($cart, $request, &$order) {
                $productIds = array_keys($cart);
                $products = Product::whereIn('id', $productIds)->lockForUpdate()->get();
                foreach ($products as $product) {
                    $quantityNeeded = $cart[$product->id]['quantity'];
                    if ($product->stock < $quantityNeeded) {
                        throw ValidationException::withMessages([
                            'cart' => 'Stok untuk produk "' . $product->name . '" tidak mencukupi. Sisa stok: ' . $product->stock,
                        ]);
                    }
                }
                $totalAmount = 0;
                foreach ($products as $product) {
                    $totalAmount += $product->price * $cart[$product->id]['quantity'];
                }

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_amount' => $totalAmount,
                    'order_code' => 'ORD-' . Str::upper(Str::random(10)) . '-' . Str::upper(Str::random(5)),
                    'status' => 'pending',
                ]);

                foreach ($products as $product) {
                    $quantity = $cart[$product->id]['quantity'];
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'subtotal' => $product->price * $quantity,
                    ]);
                    $product->decrement('stock', $quantity);
                }

                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $order->total_amount,
                    'method' => $request->payment_method,
                    'invoice' => 'INV-' . Str::upper(Str::random(10)) . '-' . Str::upper(Str::random(5)),
                ]);

                session()->forget('cart');
            });
        } catch (ValidationException $e) {
            return redirect()->route('cart.index')->withErrors($e->errors());
        }

        return redirect()
            ->route('home')
            ->with('success', 'Pesanan Anda dengan nomor #' . $order->order_code . ' berhasil dibuat!');
    }
}
