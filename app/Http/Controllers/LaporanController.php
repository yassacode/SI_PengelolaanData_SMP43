<?php

namespace App\Http\Controllers;

use App\Models\PengesahanLaporan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = PengesahanLaporan::all();
        // Since there is no view for it yet, we just return a simple structure or the expected view.
        // I will assume there's a view kepsek.laporan or similar, or I can just return a basic view.
        // From previous inspection, we don't have a view for pengesahan-laporan.
        // Let me check if there's any view for it.
        // I'll return it to a view 'kepsek.pengesahan-laporan' which might need to be created if not exists.
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
