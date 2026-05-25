<?php

namespace App\Http\Controllers;

use App\Models\Disiplin;
use App\Models\Ekstrakurikuler;
use App\Models\PengesahanLaporan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Display a listing of the reports.
     */
    public function index(): View
    {
        $this->generateMissingLaporanRecords();
        $laporans = PengesahanLaporan::orderBy('periode', 'desc')->get();
        return view('kepsek.pengesahan-laporan', compact('laporans'));
    }

    /**
     * Generate records for missing reports based on approved data.
     */
    private function generateMissingLaporanRecords(): void
    {
        // Data Disiplin yang sudah Approved oleh Waka
        $disiplinMonths = Disiplin::where('status_validasi', Disiplin::STATUS_APPROVED)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as month")
            ->distinct()
            ->pluck('month');

        foreach ($disiplinMonths as $month) {
            PengesahanLaporan::firstOrCreate(
                ['jenis_laporan' => 'Kedisiplinan', 'periode' => $month]
            );
        }

        // Data Ekskul yang sudah Approved oleh Waka
        $ekskulMonths = Ekstrakurikuler::where('status_validasi', Ekstrakurikuler::STATUS_APPROVED)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as month")
            ->distinct()
            ->pluck('month');

        foreach ($ekskulMonths as $month) {
            PengesahanLaporan::firstOrCreate(
                ['jenis_laporan' => 'Ekstrakurikuler', 'periode' => $month]
            );
        }
    }

    /**
     * Approve report by Headmaster.
     */
    public function approveKepsek(Request $request, int $id): RedirectResponse
    {
        $laporan = PengesahanLaporan::findOrFail($id);
        $laporan->update([
            'status_kepsek' => Disiplin::STATUS_APPROVED,
            'tgl_disahkan' => Carbon::now()->format('Y-m-d')
        ]);
        
        return back()->with('success', 'Laporan berhasil disahkan.');
    }

    /**
     * Export recapitulation report to PDF.
     */
    public function rekapitulasi(Request $request)
    {
        $month_disiplin = $request->input('month_disiplin');
        $month_ekskul = $request->input('month_ekskul');
        
        $disiplinQuery = Disiplin::with(['siswa', 'pelapor'])
            ->whereIn('status_validasi', [Disiplin::STATUS_APPROVED, Disiplin::STATUS_ACCEPTED]);
            
        $ekskulQuery = Ekstrakurikuler::with('pembina')
            ->whereIn('status_validasi', [Ekstrakurikuler::STATUS_APPROVED, Ekstrakurikuler::STATUS_ACCEPTED]);

        if ($month_disiplin && $monthParts = explode('-', $month_disiplin)) {
            if (count($monthParts) == 2) {
                $disiplinQuery->whereMonth('tanggal', $monthParts[1])->whereYear('tanggal', $monthParts[0]);
            }
        }

        if ($month_ekskul && $monthParts = explode('-', $month_ekskul)) {
            if (count($monthParts) == 2) {
                $ekskulQuery->whereMonth('tanggal', $monthParts[1])->whereYear('tanggal', $monthParts[0]);
            }
        }

        $disiplin = $disiplinQuery->get();
        $ekskul = $ekskulQuery->get();

        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('cetak.laporan-rekapitulasi-pdf', compact('disiplin', 'ekskul', 'month_disiplin', 'month_ekskul'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('Rekapitulasi_Laporan_SMP43.pdf');
    }

    /**
     * Preview report details.
     */
    public function preview(int $id): View
    {
        $laporan = PengesahanLaporan::findOrFail($id);
        $month = Carbon::parse($laporan->periode);
        
        if ($laporan->jenis_laporan == 'Kedisiplinan') {
            $data = Disiplin::with(['siswa', 'pelapor'])
                ->whereIn('status_validasi', [Disiplin::STATUS_APPROVED, Disiplin::STATUS_ACCEPTED])
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->get();
            
            return view('cetak.preview-laporan', [
                'data' => $data,
                'laporan' => $laporan,
                'type' => 'disiplin'
            ]);
        } else {
            $data = Ekstrakurikuler::with('pembina')
                ->whereIn('status_validasi', [Ekstrakurikuler::STATUS_APPROVED, Ekstrakurikuler::STATUS_ACCEPTED])
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->get();
                
            return view('cetak.preview-laporan', [
                'data' => $data,
                'laporan' => $laporan,
                'type' => 'ekskul'
            ]);
        }
    }
}
