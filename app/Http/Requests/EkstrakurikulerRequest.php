<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EkstrakurikulerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
        ];
    }
}
