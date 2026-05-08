<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EkstrakurikulerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("search");
        $month = $request->input('month');

        $data = Ekstrakurikuler::with('pembina')
            ->when($search, function ($query, $search) {
                return $query->where('nama_kegiatan', 'like', "%{$search}%");
            })
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('tanggal', \Carbon\Carbon::parse($month)->month)
                      ->whereYear('tanggal', \Carbon\Carbon::parse($month)->year);
            })
            ->get();

        return view('main.ekskul', [
            'data' => $data,
            'search' => $search,
            'month' => $month,
        ]);
    }

    public function create()
    {
        return view('tambah.add-ekskul', [
            'today' => date('Y-m-d'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data['user_id'] = auth()->user()->id; // Guru pembina

        if ($request->file('foto')) {
            $data['foto'] = $request->file('foto')->store('fotoBuktiEkskul', 'public');
        }

        Ekstrakurikuler::create($data);

        return redirect()->route('ekskul.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function show(Request $request)
    {
        $month = $request->input('month');
        $year = null;
        $monthNumber = null;
        
        if ($month) {
            list($year, $monthNumber) = explode('-', $month);
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

    public function edit(string $id)
    {
        $item = Ekstrakurikuler::findOrFail($id);
        return view('tambah.edit-ekskul', [
            'item' => $item,
            'today' => date('Y-m-d'),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $item = Ekstrakurikuler::findOrFail($id);
    
        $data = $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required',
            'foto' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('fotoBuktiEkskul', 'public');
        }
    
        $item->update($data);
    
        return redirect()->route('ekskul.index')->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy(string $id)
    {
        $item = Ekstrakurikuler::findOrFail($id);
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }
        $item->delete();
        
        return back()->with('success', 'Berhasil Dihapus');
    }

    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\EkskulExport, 'Data_Ekstrakurikuler_SMP43.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $month = $request->month; // Optional filter
        $query = Ekstrakurikuler::with('user');
        
        if ($month) {
            $monthParts = explode('-', $month);
            if (count($monthParts) == 2) {
                $query->whereMonth('tanggal', $monthParts[1])
                      ->whereYear('tanggal', $monthParts[0]);
            }
        }
        
        $ekstrakurikuler = $query->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('cetak.laporan-ekskul-pdf', compact('ekstrakurikuler', 'month'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('Laporan_Ekstrakurikuler_SMP43.pdf');
    }
}
