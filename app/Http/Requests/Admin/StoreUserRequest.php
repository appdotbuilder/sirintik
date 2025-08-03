<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isSuperadmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:superadmin,admin_bidang,admin_kecamatan',
            'district' => 'nullable|required_if:role,admin_kecamatan|string|max:255',
            'bidang' => 'nullable|required_if:role,admin_bidang|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.required' => 'Peran harus dipilih.',
            'role.in' => 'Peran tidak valid.',
            'district.required_if' => 'Kecamatan harus diisi untuk Admin Kecamatan.',
            'bidang.required_if' => 'Bidang harus diisi untuk Admin Bidang.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('password')) {
            $this->merge([
                'password' => Hash::make($this->password),
            ]);
        }
    }
}