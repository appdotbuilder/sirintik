<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $report = $this->route('report');
        
        // Admin Kecamatan can edit their own draft reports
        if ($user->isAdminKecamatan() && $report->user_id === $user->id && $report->status === 'draft') {
            return true;
        }
        
        // Admin Bidang and Superadmin can verify reports
        if (($user->isAdminBidang() || $user->isSuperadmin()) && in_array($report->status, ['submitted', 'verified', 'rejected'])) {
            return true;
        }
        
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        
        // Admin Kecamatan editing their own report
        if ($user->isAdminKecamatan()) {
            return [
                'report_category_id' => 'required|exists:report_categories,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'data' => 'required|array',
                'report_date' => 'required|date',
                'status' => 'nullable|in:draft,submitted',
            ];
        }
        
        // Admin Bidang/Superadmin verifying report
        return [
            'status' => 'required|in:verified,rejected',
            'verification_notes' => 'nullable|string',
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