<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Kesehatan;
use App\Models\Akademik;
use App\Models\Siswa;
use App\Models\Wali;
use App\Http\Requests\SiswaRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;
use Exception;

class SiswaController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $tahun = $request->input('tahun');

        $students = Siswa::with(['kesehatan', 'akademik', 'wali', 'prestasis', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->where('thn_msk', $tahun);
            })
            ->get();

        $years = Siswa::select('thn_msk')->distinct()->orderBy('thn_msk', 'desc')->pluck('thn_msk');
            
        return view('main.siswa', [
            'siswa' => $students,
            'search' => $search,
            'tahun' => $tahun,
            'years' => $years,
        ]);
    }

    /**
     * Show form for step 1.
     */
    public function createStep1(): View
    {
        return view('tambah.add-step1-siswa', [
            'today' => now()->format('Y-m-d'),
        ]);
    }

    /**
     * Show form for step 2.
     */
    public function createStep2(): View
    {
        $masterEkskuls = \App\Models\MasterEkskul::all();
        return view('tambah.add-step2-siswa', [
            'today' => now()->format('Y-m-d'),
            'masterEkskuls' => $masterEkskuls,
        ]);
    }

    /**
     * Show form for step 3.
     */
    public function createStep3(): View
    {
        return view('tambah.add-step3-siswa', [
            'today' => now()->format('Y-m-d'),
        ]);
    }

    /**
     * Store step 1 in session.
     */
    public function storeStep1(SiswaRequest $request): RedirectResponse
    {
        session()->put('siswa_step1', $request->validated());
        return redirect()->route('siswa.create2');
    }

    /**
     * Store step 2 in session.
     */
    public function storeStep2(SiswaRequest $request): RedirectResponse
    {
        session()->put('siswa_step2', $request->validated());
        return redirect()->route('siswa.create3');
    }

    /**
     * Store all data from steps in database.
     */
    public function store(SiswaRequest $request): RedirectResponse
    {
        $step3 = $request->validated();
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
                'alamat_ayah' => $step3['alamat_ayah'] ?? null,
                'alamat_ibu' => $step3['alamat_ibu'] ?? null,
                'no_hp_ayah' => $step3['no_hp_ayah'] ?? null,
                'no_hp_ibu' => $step3['no_hp_ibu'] ?? null,
            ]);

            // 2. Simpan Siswa
            $siswa = Siswa::create([
                'user_id' => auth()->id(),
                'wali_id' => $wali->id,
                'nisn' => $step1['nisn'] ?? '-',
                'nama' => $step1['nama'] ?? '-',
                'ttl' => $step1['ttl'] ?? '-',
                'agama' => $step1['agama'] ?? '-',
                'hobi' => $step1['hobi'] ?? null,
                'thn_msk' => $step1['thn_msk'] ?? now()->year,
                'alamat' => $step1['alamat'] ?? '-',
            ]);

            // 3. Simpan Akademik
            Akademik::create([
                'siswa_id' => $siswa->id,
                'asal_paud' => $step2['asal_paud'] ?? null,
                'asal_tk' => $step2['asal_tk'] ?? null,
                'asal_sd' => $step2['asal_sd'] ?? '-',
                'jrk_sklh' => $step2['jrk_sklh'] ?? null,
                'beasiswa' => $step2['beasiswa'] ?? null,
            ]);

            // 4. Simpan Kesehatan
            Kesehatan::create([
                'siswa_id' => $siswa->id,
                'tb' => $step1['tb'] ?? null,
                'bb' => $step1['bb'] ?? null,
                'riwayat_sakit' => $step2['sakit'] ?? null,
            ]);

            // 5. Simpan Prestasi
            for ($i = 1; $i <= 3; $i++) {
                if (!empty($step2["kegiatan{$i}"]) && !empty($step2["juara{$i}"])) {
                    Prestasi::create([
                        'siswa_id' => $siswa->id,
                        'kegiatan' => $step2["kegiatan{$i}"],
                        'juara' => $step2["juara{$i}"],
                    ]);
                }
            }

            // 6. Simpan Keanggotaan Ekskul
            if (!empty($step2['master_ekskul_ids'])) {
                $siswa->masterEkskuls()->sync($step2['master_ekskul_ids']);
            }

            DB::commit();

            session()->forget(['siswa_step1', 'siswa_step2']);
            return redirect()->route('siswa.index')->with('success', 'Data Siswa Berhasil Ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display student details (view).
     */
    public function show1(string $id): View
    {
        $siswa = Siswa::with(['kesehatan', 'akademik', 'wali', 'prestasis', 'disiplins'])->findOrFail($id);
        return view('main.view-siswa', [
            'students' => $siswa,
        ]);
    }

    /**
     * Display student details (print).
     */
    public function show2(string $id): View
    {
        $siswa = Siswa::with(['kesehatan', 'akademik', 'wali', 'prestasis', 'disiplins' => function($query) {
            $query->where('status_validasi', Disiplin::STATUS_APPROVED);
        }])->findOrFail($id);

        return view('cetak.cetak-siswa', [
            'student' => $siswa,
            'discipline' => $siswa->disiplins,
        ]);
    }

    public function editStep1(string $id): View
    {
        $siswa = Siswa::with(['kesehatan'])->findOrFail($id);
        return view('tambah.edit-step1-siswa', [
            'siswa' => $siswa,
            'today' => now()->format('Y-m-d'),
        ]);
    }

    public function editStep2(string $id): View
    {
        $siswa = Siswa::with(['akademik', 'prestasis', 'kesehatan', 'masterEkskuls'])->findOrFail($id);
        $masterEkskuls = \App\Models\MasterEkskul::all();
        return view('tambah.edit-step2-siswa', [
            'siswa' => $siswa,
            'today' => now()->format('Y-m-d'),
            'masterEkskuls' => $masterEkskuls,
        ]);
    }

    public function editStep3(string $id): View
    {
        $siswa = Siswa::with(['wali'])->findOrFail($id);
        return view('tambah.edit-step3-siswa', [
            'siswa' => $siswa,
            'today' => now()->format('Y-m-d'),
        ]);
    }

    public function updateStep1(SiswaRequest $request, int $id): RedirectResponse
    {
        session()->put('siswa_edit_step1', $request->validated());
        return redirect()->route('siswa.edit2', $id);
    }

    public function updateStep2(SiswaRequest $request, int $id): RedirectResponse
    {
        session()->put('siswa_edit_step2', $request->validated());
        return redirect()->route('siswa.edit3', $id);
    }

    public function update(SiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        $step3 = $request->validated();
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
                    'alamat_ayah' => $step3['alamat_ayah'] ?? $siswa->wali->alamat_ayah,
                    'pekerjaan_ibu' => $step3['pekerjaan_ibu'] ?? $siswa->wali->pekerjaan_ibu,
                    'alamat_ibu' => $step3['alamat_ibu'] ?? $siswa->wali->alamat_ibu,
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
                'alamat' => $step1['alamat'] ?? $siswa->alamat,
            ]);

            // Update Akademik
            if ($siswa->akademik) {
                $siswa->akademik->update([
                    'asal_paud' => $step2['asal_paud'] ?? $siswa->akademik->asal_paud,
                    'asal_tk' => $step2['asal_tk'] ?? $siswa->akademik->asal_tk,
                    'asal_sd' => $step2['asal_sd'] ?? $siswa->akademik->asal_sd,
                    'jrk_sklh' => $step2['jrk_sklh'] ?? $siswa->akademik->jrk_sklh,
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

            // Update Prestasi
            $siswa->prestasis()->delete();
            for ($i = 1; $i <= 3; $i++) {
                if (!empty($step2["kegiatan{$i}"]) && !empty($step2["juara{$i}"])) {
                    Prestasi::create([
                        'siswa_id' => $siswa->id,
                        'kegiatan' => $step2["kegiatan{$i}"],
                        'juara' => $step2["juara{$i}"],
                    ]);
                }
            }

            // Update Keanggotaan Ekskul
            if (isset($step2['master_ekskul_ids'])) {
                $siswa->masterEkskuls()->sync($step2['master_ekskul_ids']);
            }

            DB::commit();
            session()->forget(['siswa_edit_step1', 'siswa_edit_step2']);

            return redirect()->route('siswa.index')->with('success', 'Data Siswa Berhasil Diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data Berhasil Dihapus');
    }

    public function updateStts(Request $request, int $id): RedirectResponse
    {
        $siswa = Siswa::findOrFail($id);
        if ($siswa->akademik) {
            $siswa->akademik->update([
                'status' => $request->status
            ]);
        }
        return redirect()->route('siswa.index')->with('success', 'Status siswa berhasil diperbarui');
    }

    public function exportExcel(Request $request)
    {
        $tahun = $request->input('tahun');
        return Excel::download(new SiswaExport($tahun), 'Data_Siswa_SMP43.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $tahun = $request->input('tahun');
        $siswa = Siswa::with(['user', 'wali', 'akademik', 'kesehatan', 'prestasis'])
            ->when($tahun, function ($query, $tahun) {
                return $query->where('thn_msk', $tahun);
            })
            ->get();

        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('cetak.laporan-siswa-pdf', compact('siswa', 'tahun'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('Laporan_Siswa_SMP43.pdf');
    }
}
