<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $cartItems = Cart::with(['product', 'variant.size', 'variant.color'])
            ->where('user_id', $userId)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->variant->price ?? $item->product->price;
            return $price * $item->quantity;
        });

        $promo = session('promo', null);
        $discount = 0;
        if (isset($promo['type'], $promo['value'])) {
            $discount = $promo['type'] === 'percentage'
                ? $subtotal * ($promo['value'] / 100)
                : $promo['value'];
        }
        $total = $subtotal - $discount;

        return view('customer.orders.cart', compact(
            'cartItems',
            'subtotal',
            'discount',
            'total',
            'promo'
        ));
    }


    public function store(Request $request)
    {
        $product = Product::with(['sizes', 'colors'])->findOrFail($request->product_id);

        // dd($product);
        $rules = [
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ];

        if ($product->sizes->isNotEmpty()) {
            $rules['size_id'] = 'required|exists:sizes,id';
        }

        if ($product->colors->isNotEmpty()) {
            $rules['color_id'] = 'required|exists:colors,id';
        }

        // dd($rules);

        $validated = $request->validate($rules);

        // 3. Cari variant yang match (null kalau nggak ada size/color)
        $variantQuery = ProductVariant::where('product_id', $product->id);
        $variantQuery->when(isset($validated['size_id']),  fn($q) => $q->where('size_id',  $validated['size_id']))
            ->when(!isset($validated['size_id']), fn($q) => $q->whereNull('size_id'))
            ->when(isset($validated['color_id']), fn($q) => $q->where('color_id', $validated['color_id']))
            ->when(!isset($validated['color_id']), fn($q) => $q->whereNull('color_id'));

        $variant = $variantQuery->first();

        if (!$variant || $variant->qty < $validated['qty']) {
            return back()->withErrors(['qty' => 'Stok tidak tersedia!'])->withInput();
        }

        $userId = Auth::id();

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_variant_id', $variant->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $validated['qty']);
        } else {
            Cart::create([
                'user_id'            => $userId,
                'product_id'         => $product->id,
                'product_variant_id' => $variant->id,
                'quantity'           => $validated['qty'],
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($request->action === 'increase') {
            $cart->quantity++;
        } elseif ($request->action === 'decrease' && $cart->quantity > 1) {
            $cart->quantity--;
        }
        $cart->save();

        return back();
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back();
    }
}
