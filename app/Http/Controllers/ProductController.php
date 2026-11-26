<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Halaman detail (publik)
    public function show(Product $product)
    {
        $product->load(['seller', 'category', 'buyer']);

        return view('products.show', compact('product'));
    }

    public function create()
    {
        return view('products.create', [
            'categories' => Category::orderBy('id')->get(),
        ]);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        unset($data['image']);
        $data['image_path'] = $request->file('image')->store('products', 'public');

        // user_id otomatis diisi dari pengguna yang login
        $request->user()->products()->create($data);

        return redirect()->route('dashboard')->with('status', 'Barang berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);

        return view('products.edit', [
            'product'    => $product,
            'categories' => Category::orderBy('id')->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        Gate::authorize('update', $product);

        $data = $request->validated();
        unset($data['image']);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image_path); // buang foto lama
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('dashboard')->with('status', 'Barang berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        Gate::authorize('delete', $product);

        Storage::disk('public')->delete($product->image_path);
        $product->delete();

        return redirect()->route('dashboard')->with('status', 'Barang berhasil dihapus.');
    }
}