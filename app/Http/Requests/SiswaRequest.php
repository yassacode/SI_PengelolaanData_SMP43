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
                'nama' => 'required|string|max:50',
                'ttl' => 'required|string',
                'agama' => 'required|string',
                'thn_msk' => 'required|numeric',
                'alamat' => 'required|string',
            ];
        }

        if ($this->routeIs('siswa.store2') || $this->routeIs('siswa.update2')) {
            return [
                'asal_sd' => 'required|string|max:255',
                'master_ekskul_ids' => 'nullable|array',
                'master_ekskul_ids.*' => 'exists:master_ekskuls,id',
            ];
        }

        // Default / Step 3 / Final Store
        return [
            'nama_ayah' => 'required|string|max:50',
            'nama_ibu' => 'required|string|max:50',
            'pekerjaan_ayah' => 'required|string|max:50',
            'pekerjaan_ibu' => 'required|string|max:50',
            'no_hp_ayah' => 'required|string|max:13',
            'no_hp_ibu' => 'required|string|max:13',
            'alamat_ayah'=>'required|string|max:100',
            'alamat_ibu'=>'required|string|max:100',
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
            'nama_ayah.required' => 'Nama Ayah wajib diisi.',
            'nama_ibu.required' => 'Nama Ibu wajib diisi.',
            'pekerjaan_ayah.required' => 'Pekerjaan Ayah wajib diisi.',
            'pekerjaan_ibu.required' => 'Pekerjaan Ibu wajib diisi.',
            'no_hp_ayah.required' => 'Nomor HP Ayah wajib diisi.',
            'no_hp_ibu.required' => 'Nomor HP Ibu wajib diisi.',
        ];
    }
}
