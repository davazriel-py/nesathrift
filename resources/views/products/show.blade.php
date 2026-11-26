@extends('layouts.app')

@section('title', $product->title . ' - NesaThrift')

@section('content')
<div class="bg-white rounded-2xl shadow-sm overflow-hidden md:flex">
    <div class="relative md:w-1/2 bg-slate-200">
        <img src="{{ $product->image_url }}" alt="{{ $product->title }}"
             class="w-full aspect-square object-cover {{ $product->isSold() ? 'opacity-60' : '' }}">
        @if ($product->isSold())
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="bg-red-600 text-white font-bold tracking-widest px-5 py-1.5 -rotate-12 rounded shadow-lg">TERJUAL</span>
            </div>
        @endif
    </div>

    <div class="md:w-1/2 p-5 sm:p-6">
        <p class="text-2xl font-bold">{{ $product->formatted_price }}</p>
        <h1 class="text-lg font-semibold mt-1">{{ $product->title }}</h1>

        <div class="flex flex-wrap gap-2 mt-3 text-xs">
            <span class="bg-slate-100 rounded-full px-3 py-1">{{ $product->category->name }}</span>
            <span class="bg-slate-100 rounded-full px-3 py-1">{{ $product->condition_label }}</span>
            <span class="bg-slate-100 rounded-full px-3 py-1">{{ $product->location_label }}</span>
        </div>

        <p class="mt-4 text-sm leading-relaxed">{!! nl2br(e($product->description)) !!}</p>

        <div class="mt-5 border-t pt-4 text-sm">
            <p class="font-semibold">Penjual</p>
            <p>{{ $product->seller->name }}</p>
            @if ($product->seller->study_program)
                <p class="text-slate-500">{{ $product->seller->study_program }}</p>
            @endif
            <span class="inline-block mt-1 text-xs bg-green-100 text-green-700 rounded-full px-2 py-0.5">
                Terverifikasi Mahasiswa UNESA
            </span>
        </div>

        @if ($product->isSold())
            <p class="mt-4 text-sm text-slate-600">{{ $product->sold_info }}</p>
        @elseif ($product->whatsapp_chat_url)
            <a href="{{ $product->whatsapp_chat_url }}" target="_blank" rel="noopener"
               class="mt-5 block text-center bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg py-2.5">
                Chat via WhatsApp
            </a>
        @endif

        @can('update', $product)
            <a href="{{ route('products.edit', $product) }}" class="mt-3 block text-center text-blue-600 font-medium">
                Edit barang ini
            </a>
        @endcan
    </div>
</div>
@endsection