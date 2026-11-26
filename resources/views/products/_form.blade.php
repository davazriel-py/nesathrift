@php($editing = isset($product))

<div>
    <label class="block text-sm font-medium mb-1">Judul Barang</label>
    <input type="text" name="title" value="{{ old('title', $editing ? $product->title : '') }}" required maxlength="100"
           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Kategori</label>
        <select name="category_id" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Pilih kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $editing ? $product->category_id : '') == $c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
        <input type="number" name="price" min="0" step="1" required
               value="{{ old('price', $editing ? $product->price : '') }}"
               class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Kondisi</label>
        <select name="condition" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach (\App\Models\Product::CONDITIONS as $value => $label)
                <option value="{{ $value }}" @selected(old('condition', $editing ? $product->condition : '') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('condition') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Lokasi COD</label>
        <select name="campus_location" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach (\App\Models\Product::LOCATIONS as $value => $label)
                <option value="{{ $value }}" @selected(old('campus_location', $editing ? $product->campus_location : '') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('campus_location') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Deskripsi</label>
    <textarea name="description" rows="5" required maxlength="2000"
              class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $editing ? $product->description : '') }}</textarea>
    @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">
        Foto Barang <span class="text-slate-400 font-normal">(JPG/PNG/WEBP, maks 2 MB)</span>
    </label>

    <img id="preview" src="{{ $editing ? $product->image_url : '' }}" alt="Pratinjau"
         class="{{ $editing ? '' : 'hidden' }} w-40 h-40 rounded-lg object-cover mb-2 bg-slate-200">

    <input type="file" name="image" accept="image/jpeg,image/png,image/webp" {{ $editing ? '' : 'required' }}
           onchange="const f=this.files[0]; if(f){const p=document.getElementById('preview'); p.src=URL.createObjectURL(f); p.classList.remove('hidden');}"
           class="block w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-blue-700">
    @if ($editing) <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengganti foto.</p> @endif
    @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>