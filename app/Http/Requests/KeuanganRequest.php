<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class KeuanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategori_keuangan,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'kategori_id.required' => 'Kategori keuangan wajib dipilih.',
            'kategori_id.exists' => 'Kategori keuangan tidak ditemukan.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal harus 1.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status_code'=>422,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()
        ], 422));
    }
}
