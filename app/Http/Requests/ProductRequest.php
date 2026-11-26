<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // hak akses pemilik dicek di controller lewat Policy
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title'       => trim(strip_tags((string) $this->title)),
            'description' => trim(strip_tags((string) $this->description)),
        ]);
    }

    public function rules(): array
    {
        return [
            'title'           => ['required', 'string', 'max:100'],
            'category_id'     => ['required', 'exists:categories,id'],
            'price'           => ['required', 'integer', 'min:0', 'max:1000000000'],
            'condition'       => ['required', Rule::in(array_keys(Product::CONDITIONS))],
            'campus_location' => ['required', Rule::in(array_keys(Product::LOCATIONS))],
            'description'     => ['required', 'string', 'max:2000'],
            'image'           => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Foto barang wajib diupload.',
            'image.mimes'    => 'Foto harus berformat JPG, PNG, atau WEBP.',
            'image.max'      => 'Ukuran foto maksimal 2 MB.',
            'price.integer'  => 'Harga harus berupa angka bulat (tanpa titik atau koma).',
        ];
    }
}