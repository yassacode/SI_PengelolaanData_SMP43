<?php

namespace App\Http\Controllers;

use App\Models\PengesahanLaporan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $this->generateMissingLaporanRecords();
        $laporans = PengesahanLaporan::orderBy('periode', 'desc')->get();
        return view('kepsek.pengesahan-laporan', compact('laporans'));
    }

    private function generateMissingLaporanRecords()
    {
        // Data Disiplin yang sudah Approved oleh Waka
        $disiplinMonths = \App\Models\Disiplin::where('status_validasi', 'Approved')
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as month")
            ->distinct()
            ->pluck('month');

        foreach ($disiplinMonths as $month) {
            PengesahanLaporan::firstOrCreate(
                ['jenis_laporan' => 'Kedisiplinan', 'periode' => $month]
            );
        }

        // Data Ekskul yang sudah Approved oleh Waka
        $ekskulMonths = \App\Models\Ekstrakurikuler::where('status_validasi', 'Approved')
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as month")
            ->distinct()
            ->pluck('month');

        foreach ($ekskulMonths as $month) {
            PengesahanLaporan::firstOrCreate(
                ['jenis_laporan' => 'Ekstrakurikuler', 'periode' => $month]
            );
        }
    }

    public function approveKepsek(Request $request, $id)
    {
        $laporan = PengesahanLaporan::findOrFail($id);
        $laporan->update([
            'status_kepsek' => 'Approved',
            'tgl_disahkan' => Carbon::now()->format('Y-m-d')
        ]);
        
        return back()->with('success', 'Laporan berhasil disahkan.');
    }

    public function rekapitulasi(Request $request)
    {
        $month_disiplin = $request->input('month_disiplin');
        $month_ekskul = $request->input('month_ekskul');
        
        $disiplinQuery = \App\Models\Disiplin::with(['siswa', 'pelapor'])
            ->whereIn('status_validasi', ['Approved', 'ACCEPTED']);
            
        $ekskulQuery = \App\Models\Ekstrakurikuler::with('pembina')
            ->whereIn('status_validasi', ['Approved', 'ACCEPTED']);

        if ($month_disiplin) {
            $monthParts = explode('-', $month_disiplin);
            if (count($monthParts) == 2) {
                $disiplinQuery->whereMonth('tanggal', $monthParts[1])->whereYear('tanggal', $monthParts[0]);
            }
        }

        if ($month_ekskul) {
            $monthParts = explode('-', $month_ekskul);
            if (count($monthParts) == 2) {
                $ekskulQuery->whereMonth('tanggal', $monthParts[1])->whereYear('tanggal', $monthParts[0]);
            }
        }

        $disiplin = $disiplinQuery->get();
        $ekskul = $ekskulQuery->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('cetak.laporan-rekapitulasi-pdf', compact('disiplin', 'ekskul', 'month_disiplin', 'month_ekskul'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('Rekapitulasi_Laporan_SMP43.pdf');
    }

    public function preview($id)
    {
        $laporan = PengesahanLaporan::findOrFail($id);
        $month = $laporan->periode;
        
        if ($laporan->jenis_laporan == 'Kedisiplinan') {
            $data = \App\Models\Disiplin::with(['siswa', 'pelapor'])
                ->whereIn('status_validasi', ['Approved', 'ACCEPTED'])
                ->whereMonth('tanggal', date('m', strtotime($month)))
                ->whereYear('tanggal', date('Y', strtotime($month)))
                ->get();
            
            return view('cetak.preview-laporan', [
                'data' => $data,
                'laporan' => $laporan,
                'type' => 'disiplin'
            ]);
        } else {
            $data = \App\Models\Ekstrakurikuler::with('pembina')
                ->whereIn('status_validasi', ['Approved', 'ACCEPTED'])
                ->whereMonth('tanggal', date('m', strtotime($month)))
                ->whereYear('tanggal', date('Y', strtotime($month)))
                ->get();
                
            return view('cetak.preview-laporan', [
                'data' => $data,
                'laporan' => $laporan,
                'type' => 'ekskul'
            ]);
        }
    }
}
