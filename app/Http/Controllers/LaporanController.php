<?php

namespace App\Http\Controllers;

use App\Models\PengesahanLaporan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = PengesahanLaporan::latest()->get();
        return view('kepsek.pengesahan-laporan', compact('laporans'));
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
}
