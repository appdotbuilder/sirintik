<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdminKecamatan();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'report_category_id' => 'required|exists:report_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'data' => 'required|array',
            'report_date' => 'required|date',
            'status' => 'nullable|in:draft,submitted',
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
            'report_category_id.required' => 'Kategori laporan harus dipilih.',
            'report_category_id.exists' => 'Kategori laporan tidak valid.',
            'title.required' => 'Judul laporan harus diisi.',
            'title.max' => 'Judul laporan maksimal 255 karakter.',
            'data.required' => 'Data laporan harus diisi.',
            'data.array' => 'Format data laporan tidak valid.',
            'report_date.required' => 'Tanggal laporan harus diisi.',
            'report_date.date' => 'Format tanggal laporan tidak valid.',
            'status.in' => 'Status laporan tidak valid.',
        ];
    }
}