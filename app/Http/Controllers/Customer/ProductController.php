<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query produk
        $query = Product::with(['category', 'variants'])
            ->where('is_active', true)
            ->where('is_stock', true);

        // Filter kategori
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->whereIn('slug', $request->category);
            });
        }

        // Filter by size (berdasarkan ID size dari tabel sizes)
        if ($request->filled('size')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('product_size_id', $request->size);
            });
        }

        if ($request->filled('color')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('product_color_id', $request->color);
            });
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $sizes = ProductSize::all(); // ambil list size dari DB
        $colors = ProductColor::all(); // ambil list size dari DB

        return view('customer.products.index', compact('products', 'categories', 'sizes', 'colors'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['variants.size', 'variants.color']) // include relasi size & color
            ->firstOrFail();

        // Ambil unique sizes & colors sebagai objek model
        $sizes = $product->variants->pluck('size')->unique('id');
        $colors = $product->variants->pluck('color')->unique('id');

        $variants = $product->variants->map(function ($variant) {
            return [
                'size_id' => $variant->product_size_id,
                'color_id' => $variant->product_color_id,
                'qty' => $variant->qty,
                'image' => $variant->image,
            ];
        });

        $products = Product::take(4)->get();

        return view('customer.products.show', compact('product', 'sizes', 'colors', 'variants', 'products'));
    }
}
