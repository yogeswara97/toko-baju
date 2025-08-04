<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $products = Product::with('category')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        $colors = ProductColor::all();
        $sizes = ProductSize::all();

        return view('admin.products.form', [
            'product' => null,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['is_stock'] = $request->has('is_stock');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['slug'] = Str::slug($request->name);
        $product = Product::create($data);

        // === Simpan Variant ===
        if ($request->has('variants') && count($request->variants)) {
            $combinations = [];
            foreach ($request->variants as $v) {
                $key = ($v['color_id'] ?? 'null') . '-' . ($v['size_id'] ?? 'null');
                if (in_array($key, $combinations)) {
                    return back()->withInput()->withErrors(['variants' => 'Terdapat kombinasi warna & ukuran yang sama pada variant.']);
                }
                $combinations[] = $key;
            }

            foreach ($request->variants as $variantData) {
                $variant = new ProductVariant();
                $variant->product_id = $product->id;
                $variant->product_color_id = $variantData['color_id'] ?? null;
                $variant->product_size_id = $variantData['size_id'] ?? null;
                $variant->qty = $variantData['qty'] ?? 0;
                $variant->price = $variantData['price'] ?? null;

                if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $variant->image = $variantData['image']->store('product_variants', 'public');
                }

                $variant->save();
            }
        } else {
            // === Kasus aksesori: variant default ===
            ProductVariant::create([
                'product_id' => $product->id,
                'product_color_id' => null,
                'product_size_id' => null,
                'qty' => 0,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $colors = ProductColor::all();
        $sizes = ProductSize::all();

        $product->load('variants.color', 'variants.size');

        return view('admin.products.form', compact('product', 'categories', 'colors', 'sizes'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['is_stock'] = $request->has('is_stock');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['slug'] = Str::slug($request->name);
        $product->update($data);

        // === Sync Variants ===
        $existingVariantIds = $product->variants()->pluck('id')->toArray();
        $submittedVariantIds = [];

        if ($request->has('variants') && count($request->variants)) {
            $combinations = [];
            foreach ($request->variants as $v) {
                $key = ($v['color_id'] ?? 'null') . '-' . ($v['size_id'] ?? 'null');
                if (in_array($key, $combinations)) {
                    return back()->withInput()->withErrors(['variants' => 'Terdapat kombinasi warna & ukuran yang sama pada variant.']);
                }
                $combinations[] = $key;
            }

            foreach ($request->variants as $variantData) {
                if (!empty($variantData['id'])) {
                    // Update existing variant
                    $variant = \App\Models\ProductVariant::find($variantData['id']);
                    if (!$variant || $variant->product_id !== $product->id) continue;

                    $variant->update([
                        'product_color_id' => $variantData['color_id'] ?? null,
                        'product_size_id' => $variantData['size_id'] ?? null,
                        'qty' => $variantData['qty'] ?? 0,
                        'price' => $variantData['price'] ?? null,
                    ]);

                    if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $variant->image = $variantData['image']->store('product_variants', 'public');
                        $variant->save();
                    }

                    $submittedVariantIds[] = $variant->id;
                } else {
                    // Cek apakah kombinasi ini sudah ada
                    $variant = \App\Models\ProductVariant::firstOrNew([
                        'product_id' => $product->id,
                        'product_color_id' => $variantData['color_id'] ?? null,
                        'product_size_id' => $variantData['size_id'] ?? null,
                    ]);

                    $variant->qty = $variantData['qty'] ?? 0;
                    $variant->price = $variantData['price'] ?? null;

                    if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $variant->image = $variantData['image']->store('product_variants', 'public');
                    }

                    $variant->save();
                    $submittedVariantIds[] = $variant->id;
                }
            }

            // Hapus variant yang tidak dikirim
            $toDelete = array_diff($existingVariantIds, $submittedVariantIds);
            \App\Models\ProductVariant::whereIn('id', $toDelete)->delete();
        } else {
            // Kalau gak ada variant dikirim, bikin dummy
            $product->variants()->delete();

            \App\Models\ProductVariant::create([
                'product_id' => $product->id,
                'product_color_id' => null,
                'product_size_id' => null,
                'qty' => 0,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated!');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }
}
