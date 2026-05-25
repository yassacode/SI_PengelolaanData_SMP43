<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisiplinRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'siswa_id' => 'required|exists:siswas,id',
            'masalah' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'siswa_id.required' => 'Siswa harus dipilih.',
            'siswa_id.exists' => 'Siswa tidak valid.',
            'masalah.required' => 'Jenis pelanggaran/masalah wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'keterangan.required' => 'Keterangan/tindakan wajib diisi.',
        ];
    }
}
