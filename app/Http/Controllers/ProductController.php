<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ── List all products ────────────────────────────────────────────────────
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // ── Show create form ─────────────────────────────────────────────────────
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    // ── Store new product ────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'price'             => 'required|numeric|min:0',
            'old_price'         => 'nullable|numeric|min:0',
            'short_description' => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'brand'             => 'nullable|string|max:100',
            'stock_quantity'    => 'required|integer|min:0',
            'stock_status'      => 'required|in:In Stock,Out of Stock',
            'is_featured'       => 'nullable|boolean',
            'image'             => 'nullable|image|max:4096',
        ]);

        if ((int)$data['stock_quantity'] === 0) {
            $data['stock_status'] = 'Out of Stock';
        }

        $slug = Str::slug($data['name']);
        $count = Product::where('slug', 'like', $slug . '%')->count();
        $data['slug']        = $count ? "{$slug}-" . ($count + 1) : $slug;
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
                         ->with('message', 'Product added successfully!');
    }

    // ── Show edit form ───────────────────────────────────────────────────────
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // ── Update product ───────────────────────────────────────────────────────
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'price'             => 'required|numeric|min:0',
            'old_price'         => 'nullable|numeric|min:0',
            'short_description' => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'brand'             => 'nullable|string|max:100',
            'stock_quantity'    => 'required|integer|min:0',
            'stock_status'      => 'required|in:In Stock,Out of Stock',
            'is_featured'       => 'nullable|boolean',
            'image'             => 'nullable|image|max:4096',
        ]);

        if ((int)$data['stock_quantity'] === 0) {
            $data['stock_status'] = 'Out of Stock';
        }

        if ($product->name !== $data['name']) {
            $slug = Str::slug($data['name']);
            $count = Product::where('slug', 'like', $slug . '%')->where('id', '!=', $product->id)->count();
            $data['slug'] = $count ? "{$slug}-" . ($count + 1) : $slug;
        }

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            // Delete old image if stored in public storage disk
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
                         ->with('message', 'Product updated successfully!');
    }

    // ── Delete product ───────────────────────────────────────────────────────
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('message', 'Product deleted.');
    }
}
