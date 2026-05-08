<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Disiplin;
use App\Models\Kesehatan;
use App\Models\Akademik;
use App\Models\Siswa;
use App\Models\Wali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $students = Siswa::with(['kesehatan', 'akademik', 'wali', 'prestasis', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->get();
            
        return view('main.siswa', [
            'siswa' => $students,
            'search' => $search,
        ]);
    }

    public function createStep1()
    {
        return view('tambah.add-step1-siswa', [
            'today' => date('Y-m-d'),
        ]);
    }

    public function createStep2()
    {
        return view('tambah.add-step2-siswa', [
            'today' => date('Y-m-d'),
        ]);
    }

    public function createStep3()
    {
        return view('tambah.add-step3-siswa', [
            'today' => date('Y-m-d'),
        ]);
    }

    public function storeStep1(Request $request)
    {
        // Sesuaikan dengan input dari form UI saat ini
        $data = $request->except('_token');
        session()->put('siswa_step1', $data);
        return redirect()->route('siswa.create2');
    }

    public function storeStep2(Request $request)
    {
        $data = $request->except('_token');
        session()->put('siswa_step2', $data);
        return redirect()->route('siswa.create3');
    }

    public function store(Request $request)
    {
        // Data step 3 (Wali) dikirim langsung via POST dari form terakhir
        $step3 = $request->except('_token');
        $step1 = session()->get('siswa_step1', []);
        $step2 = session()->get('siswa_step2', []);

        DB::beginTransaction();
        try {
            // 1. Simpan Wali
            $wali = Wali::create([
                'nama_ayah' => $step3['nama_ayah'] ?? null,
                'nama_ibu' => $step3['nama_ibu'] ?? null,
                'pekerjaan_ayah' => $step3['pekerjaan_ayah'] ?? null,
                'pekerjaan_ibu' => $step3['pekerjaan_ibu'] ?? null,
                'no_hp_ayah' => $step3['no_hp_ayah'] ?? null,
                'no_hp_ibu' => $step3['no_hp_ibu'] ?? null,
            ]);

            // 2. Simpan Siswa
            $siswa = Siswa::create([
                'user_id' => auth()->id(), // Staff yang menginput
                'wali_id' => $wali->id,
                'nisn' => $step1['nisn'] ?? '-',
                'nama' => $step1['nama'] ?? '-',
                'ttl' => $step1['ttl'] ?? '-',
                'agama' => $step1['agama'] ?? '-',
                'hobi' => $step1['hobi'] ?? null,
                'thn_msk' => $step1['thn_msk'] ?? date('Y'),
            ]);

            // 3. Simpan Akademik
            Akademik::create([
                'siswa_id' => $siswa->id,
                'asal_paud' => $step2['asal_paud'] ?? null,
                'asal_tk' => $step2['asal_tk'] ?? null,
                'asal_sd' => $step2['asal_sd'] ?? '-',
                'beasiswa' => $step2['beasiswa'] ?? null,
            ]);

            // 4. Simpan Kesehatan
            Kesehatan::create([
                'siswa_id' => $siswa->id,
                'tb' => $step1['tb'] ?? null,
                'bb' => $step1['bb'] ?? null,
                'riwayat_sakit' => $step2['sakit'] ?? null,
            ]);

            // 5. Simpan Prestasi (jika ada input dari form lama, ambil loop)
            for ($i = 1; $i <= 5; $i++) {
                if (!empty($step2["kegiatan{$i}"]) && !empty($step2["juara{$i}"])) {
                    Prestasi::create([
                        'siswa_id' => $siswa->id,
                        'kegiatan' => $step2["kegiatan{$i}"],
                        'juara' => $step2["juara{$i}"],
                    ]);
                }
            }

            DB::commit();

            session()->forget(['siswa_step1', 'siswa_step2']);
            return redirect()->route('siswa.index')->with('success', 'Data Siswa Berhasil Ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show1(string $id)
    {
        $siswa = Siswa::with(['kesehatan', 'akademik', 'wali', 'prestasis', 'disiplins'])->findOrFail($id);
        return view('main.view-siswa', [
            'students' => $siswa,
        ]);
    }

    public function show2(string $id)
    {
        $siswa = Siswa::with(['kesehatan', 'akademik', 'wali', 'prestasis', 'disiplins'])->findOrFail($id);
        return view('cetak.cetak-siswa', [
            'student' => $siswa,
            'discipline' => $siswa->disiplins,
        ]);
    }

    public function editStep1(string $id)
    {
        $siswa = Siswa::with(['kesehatan'])->findOrFail($id);
        return view('tambah.edit-step1-siswa', [
            'siswa' => $siswa,
            'today' => date('Y-m-d'),
        ]);
    }

    public function editStep2(string $id)
    {
        $siswa = Siswa::with(['akademik', 'prestasis', 'kesehatan'])->findOrFail($id);
        return view('tambah.edit-step2-siswa', [
            'siswa' => $siswa,
            'today' => date('Y-m-d'),
        ]);
    }

    public function editStep3(string $id)
    {
        $siswa = Siswa::with(['wali'])->findOrFail($id);
        return view('tambah.edit-step3-siswa', [
            'siswa' => $siswa,
            'today' => date('Y-m-d'),
        ]);
    }

    public function updateStep1(Request $request, $id)
    {
        session()->put('siswa_edit_step1', $request->except('_token'));
        return redirect()->route('siswa.edit2', $id);
    }

    public function updateStep2(Request $request, $id)
    {
        session()->put('siswa_edit_step2', $request->except('_token'));
        return redirect()->route('siswa.edit3', $id);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $step3 = $request->except('_token');
        $step1 = session()->get('siswa_edit_step1', []);
        $step2 = session()->get('siswa_edit_step2', []);

        DB::beginTransaction();
        try {
            // Update Wali
            if ($siswa->wali) {
                $siswa->wali->update([
                    'nama_ayah' => $step3['nama_ayah'] ?? $siswa->wali->nama_ayah,
                    'nama_ibu' => $step3['nama_ibu'] ?? $siswa->wali->nama_ibu,
                    'pekerjaan_ayah' => $step3['pekerjaan_ayah'] ?? $siswa->wali->pekerjaan_ayah,
                    'pekerjaan_ibu' => $step3['pekerjaan_ibu'] ?? $siswa->wali->pekerjaan_ibu,
                    'no_hp_ayah' => $step3['no_hp_ayah'] ?? $siswa->wali->no_hp_ayah,
                    'no_hp_ibu' => $step3['no_hp_ibu'] ?? $siswa->wali->no_hp_ibu,
                ]);
            }

            // Update Siswa
            $siswa->update([
                'nisn' => $step1['nisn'] ?? $siswa->nisn,
                'nama' => $step1['nama'] ?? $siswa->nama,
                'ttl' => $step1['ttl'] ?? $siswa->ttl,
                'agama' => $step1['agama'] ?? $siswa->agama,
                'hobi' => $step1['hobi'] ?? $siswa->hobi,
                'thn_msk' => $step1['thn_msk'] ?? $siswa->thn_msk,
            ]);

            // Update Akademik
            if ($siswa->akademik) {
                $siswa->akademik->update([
                    'asal_paud' => $step2['asal_paud'] ?? $siswa->akademik->asal_paud,
                    'asal_tk' => $step2['asal_tk'] ?? $siswa->akademik->asal_tk,
                    'asal_sd' => $step2['asal_sd'] ?? $siswa->akademik->asal_sd,
                    'beasiswa' => $step2['beasiswa'] ?? $siswa->akademik->beasiswa,
                ]);
            }

            // Update Kesehatan
            if ($siswa->kesehatan) {
                $siswa->kesehatan->update([
                    'tb' => $step1['tb'] ?? $siswa->kesehatan->tb,
                    'bb' => $step1['bb'] ?? $siswa->kesehatan->bb,
                    'riwayat_sakit' => $step2['sakit'] ?? $siswa->kesehatan->riwayat_sakit,
                ]);
            }

            // Untuk prestasi, hapus yang lama dan buat baru (opsional) atau update sesuai logic.
            // Karena ini disederhanakan, kita biarkan saja atau buat baru jika diisi.
            if (!empty($step2['kegiatan']) && !empty($step2['juara'])) {
                Prestasi::create([
                    'siswa_id' => $siswa->id,
                    'kegiatan' => $step2['kegiatan'],
                    'juara' => $step2['juara'],
                ]);
            }

            DB::commit();
            session()->forget(['siswa_edit_step1', 'siswa_edit_step2']);

            return redirect()->route('siswa.index')->with('success', 'Data Siswa Berhasil Diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        // Cascade delete akan menghapus Akademik, Kesehatan, Prestasi, Disiplin, Pivot Ekskul
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data Berhasil Dihapus');
    }

    public function updateStts(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        if ($siswa->akademik) {
            $siswa->akademik->update([
                'status' => $request->status
            ]);
        }
        return redirect()->route('siswa.index')->with('success', 'Status siswa berhasil diperbarui');
    }

    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SiswaExport, 'Data_Siswa_SMP43.xlsx');
    }

    public function exportPdf()
    {
        $siswa = Siswa::with(['user', 'wali', 'akademik', 'kesehatan', 'prestasis'])->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('cetak.laporan-siswa-pdf', compact('siswa'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('Laporan_Siswa_SMP43.pdf');
    }
}
