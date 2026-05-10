<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Http\Requests\EkstrakurikulerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EkskulExport;
use Exception;

class EkstrakurikulerController extends Controller
{
    /**
     * Display a listing of extracurricular activities.
     */
    public function index(Request $request): View
    {
        $search = $request->input("search");
        $month = $request->input('month');

        $data = Ekstrakurikuler::with('pembina')
            ->when($search, function ($query, $search) {
                return $query->where('nama_kegiatan', 'like', "%{$search}%");
            })
            ->when($month, function ($query) use ($month) {
                $carbon = Carbon::parse($month);
                $query->whereMonth('tanggal', $carbon->month)
                      ->whereYear('tanggal', $carbon->year);
            })
            ->get();

        return view('main.ekskul', [
            'data' => $data,
            'search' => $search,
            'month' => $month,
        ]);
    }

    /**
     * Show form for creating a new activity.
     */
    public function create(): View
    {
        return view('tambah.add-ekskul', [
            'today' => now()->format('Y-m-d'),
        ]);
    }

    /**
     * Store a newly created activity.
     */
    public function store(EkstrakurikulerRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status_validasi'] = Ekstrakurikuler::STATUS_PENDING;

        if ($request->file('foto')) {
            $data['foto'] = $request->file('foto')->store('fotoBuktiEkskul', 'public');
        }

        Ekstrakurikuler::create($data);

        return redirect()->route('ekskul.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display activities for printing.
     */
    public function show(Request $request): View
    {
        $month = $request->input('month');
        $year = null;
        $monthNumber = null;
        
        if ($month && $parts = explode('-', $month)) {
            if (count($parts) == 2) {
                $year = $parts[0];
                $monthNumber = $parts[1];
            }
        }
        
        $data = Ekstrakurikuler::with('pembina')
            ->when($monthNumber, function ($query) use ($monthNumber, $year) {
                return $query->whereMonth('tanggal', $monthNumber)
                             ->whereYear('tanggal', $year);
            })
            ->get();

        return view('cetak.cetak-ekskul', [
            'item' => $data,
            'month' => $month
        ]);
    }

    /**
     * Show form for editing.
     */
    public function edit(string $id): View
    {
        $item = Ekstrakurikuler::findOrFail($id);
        return view('tambah.edit-ekskul', [
            'item' => $item,
            'today' => now()->format('Y-m-d'),
        ]);
    }

    /**
     * Update the activity.
     */
    public function update(EkstrakurikulerRequest $request, string $id): RedirectResponse
    {
        $item = Ekstrakurikuler::findOrFail($id);
        $data = $request->validated();
    
        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('fotoBuktiEkskul', 'public');
        }
    
        $item->update($data);
    
        return redirect()->route('ekskul.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Delete the activity.
     */
    public function destroy(string $id): RedirectResponse
    {
        $item = Ekstrakurikuler::findOrFail($id);
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }
        $item->delete();
        
        return back()->with('success', 'Berhasil Dihapus');
    }

    /**
     * Update status of activity (Waka).
     */
    public function updateStts(Request $request, int $id): RedirectResponse
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
        $ekskul->update([
            'status_validasi' => $request->status,
            'validator_id' => auth()->id()
        ]);

        return redirect()->route('ekskul.index')->with('success', 'Status kegiatan ekstrakurikuler berhasil diperbarui');
    }

    /**
     * Export to Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new \App\Exports\EkskulExport, 'Data_Ekstrakurikuler_SMP43.xlsx');
    }

    /**
     * Export to PDF.
     */
    public function exportPdf(Request $request)
    {
        $month = $request->month;
        $query = Ekstrakurikuler::with('pembina');
        
        if ($month && $parts = explode('-', $month)) {
            if (count($parts) == 2) {
                $query->whereMonth('tanggal', $parts[1])
                      ->whereYear('tanggal', $parts[0]);
            }
        }
        
        $ekstrakurikuler = $query->get();
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('cetak.laporan-ekskul-pdf', compact('ekstrakurikuler', 'month'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('Laporan_Ekstrakurikuler_SMP43.pdf');
    }
}
