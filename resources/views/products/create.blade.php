@extends('layouts.app')

@section('title', 'Jual Barang - NesaThrift')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm p-5 sm:p-8">
    <h1 class="text-xl font-semibold mb-5">Jual Barang</h1>

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @include('products._form')

        <div class="flex gap-3 pt-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-5 py-2.5">Simpan</button>
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-slate-600">Batal</a>
        </div>
    </form>
</div>
@endsection