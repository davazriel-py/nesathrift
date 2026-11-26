@extends('layouts.app')

@section('title', 'Dashboard - NesaThrift')

@section('content')
<h1 class="text-xl font-semibold mb-4">Dashboard {{ auth()->user()->name }}</h1>

{{-- Statistik --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-sm text-slate-500">Barang Aktif</p>
        <p class="text-2xl font-bold text-blue-600">{{ $activeCount }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-sm text-slate-500">Barang Terjual</p>
        <p class="text-2xl font-bold text-green-600">{{ $soldCount }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-sm text-slate-500">Total Pendapatan</p>
        <p class="text-2xl font-bold">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Daftar barang saya --}}
<div class="flex items-center justify-between mb-3">
    <h2 class="font-semibold">Barang Saya</h2>
    <a href="{{ route('products.create') }}" class="text-sm text-blue-600 font-medium">+ Tambah barang</a>
</div>

@forelse ($products as $product)
    <div class="bg-white rounded-xl shadow-sm p-3 mb-3 flex gap-3 items-center">
        <img src="{{ $product->image_url }}" alt="{{ $product->title }}"
             class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg object-cover shrink-0 bg-slate-200">

        <div class="flex-1 min-w-0">
            <p class="font-semibold truncate">{{ $product->title }}</p>
            <p class="text-blue-600 font-bold">{{ $product->formatted_price }}</p>
            <p class="text-xs text-slate-500 truncate">
                {{ $product->category->name }} · {{ $product->condition_label }} · {{ $product->location_label }}
            </p>
            <span class="inline-block mt-1 text-xs rounded-full px-2 py-0.5
                {{ $product->isSold() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                {{ $product->isSold() ? 'Terjual' : 'Tersedia' }}
            </span>
        </div>

        <div class="flex flex-col gap-1 text-sm text-right shrink-0">
            <a href="{{ route('products.show', $product) }}" class="text-slate-600 hover:text-blue-600">Lihat</a>
            @can('update', $product)
                <a href="{{ route('products.edit', $product) }}" class="text-blue-600 font-medium">Edit</a>
            @endcan
            @can('delete', $product)
                <form method="POST" action="{{ route('products.destroy', $product) }}"
                      onsubmit="return confirm('Hapus barang ini? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
            @endcan
        </div>
    </div>
@empty
    <div class="bg-white rounded-xl p-10 text-center text-slate-500">
        Kamu belum punya barang. <a href="{{ route('products.create') }}" class="text-blue-600 font-medium">Jual barang pertamamu</a>.
    </div>
@endforelse

<div class="mt-4">{{ $products->links() }}</div>
@endsection