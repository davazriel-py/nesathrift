<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email'    => strtolower(trim((string) $this->email)),
            'name'     => trim(strip_tags((string) $this->name)),
            'whatsapp' => $this->normalizeWhatsapp($this->whatsapp),
        ]);
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email:rfc', 'max:150', 'unique:users,email', 'ends_with:@mhs.unesa.ac.id'],
            'faculty'       => ['nullable', 'string', 'max:100'],
            'study_program' => ['nullable', 'string', 'max:100'],
            'whatsapp'      => ['nullable', 'regex:/^628\d{8,12}$/'],
            'password'      => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ];
    }

    public function messages(): array
    {
        return [
            'email.ends_with' => 'Hanya email mahasiswa UNESA (@mhs.unesa.ac.id) yang boleh mendaftar.',
            'email.unique'    => 'Email ini sudah terdaftar.',
            'whatsapp.regex'  => 'Nomor WhatsApp harus berformat 628xxxxxxxxxx.',
        ];
    }

    // 0812xxx / 62812xxx -> 62812xxx
    private function normalizeWhatsapp(?string $number): ?string
    {
        if (! $number) {
            return null;
        }
        $digits = preg_replace('/\D/', '', $number);

        return str_starts_with($digits, '08')
            ? '62' . substr($digits, 1)
            : $digits;
    }
}