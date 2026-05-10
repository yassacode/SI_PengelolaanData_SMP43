<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRequest extends FormRequest
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
        // Rules vary depending on the step, but we define them all here
        // and apply them conditionally in the controller or use them for the final store.
        
        if ($this->routeIs('siswa.store1') || $this->routeIs('siswa.update1')) {
            return [
                'nisn' => 'required|string|max:20',
                'nama' => 'required|string|max:255',
                'ttl' => 'required|string',
                'agama' => 'required|string',
                'thn_msk' => 'required|numeric',
                'alamat' => 'required|string',
            ];
        }

        if ($this->routeIs('siswa.store2') || $this->routeIs('siswa.update2')) {
            return [
                'asal_sd' => 'required|string|max:255',
            ];
        }

        // Default / Step 3 / Final Store
        return [
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'no_hp_ayah' => 'nullable|string|max:20',
            'no_hp_ibu' => 'nullable|string|max:20',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nisn.required' => 'NISN wajib diisi.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'ttl.required' => 'Tempat, Tanggal Lahir wajib diisi.',
            'agama.required' => 'Agama wajib diisi.',
            'thn_msk.required' => 'Tahun masuk wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'asal_sd.required' => 'Asal SD wajib diisi.',
        ];
    }
}
