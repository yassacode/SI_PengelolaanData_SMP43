<?php

namespace App\Http\Controllers;

use App\Models\Disiplin;
use App\Models\Siswa;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DisiplinController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $month = $request->input('month');

        $disciplines = Disiplin::with(['siswa', 'pelapor', 'validator'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('masalah', 'like', "%{$search}%")
                        ->orWhere('tanggal', 'like', "%{$search}%")
                        ->orWhereHas('siswa', function ($query) use ($search) {
                            $query->where('nama', 'like', "%{$search}%");
                        })
                        ->orWhereHas('pelapor', function ($query) use ($search) {
                            $query->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('tanggal', \Carbon\Carbon::parse($month)->month)
                      ->whereYear('tanggal', \Carbon\Carbon::parse($month)->year);
            })
            ->get();

        return view('main.disiplin', [
            'disiplin' => $disciplines,
            'search' => $search,
            'month' => $month,
        ]);
    }

    public function create()
    {
        $students = Siswa::all();
        return view('tambah.add-disiplin', [
            'today' => date('Y-m-d'),
            'siswa' => $students
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "siswa_id" => 'required|exists:siswas,id',
            "masalah" => 'required',
            "tanggal" => 'required',
            "keterangan" => 'required',
            "foto" => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validatedData['user_id'] = auth()->user()->id; // Guru BK yang melapor
        $validatedData['status_validasi'] = 'Pending'; // Default status

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('fotoBuktiDisiplin', 'public');
        }

        Disiplin::create($validatedData);

        return redirect()->route('disiplin.index')->with('success', 'Data Pelanggaran Berhasil Dilaporkan');
    }

    public function show(Request $request)
    {
        $month = $request->input('month');
        $year = null;
        $monthNumber = null;

        if ($month) {
            list($year, $monthNumber) = explode('-', $month);
        }

        $disciplines = Disiplin::with(['siswa', 'pelapor'])
            ->where('status_validasi', 'Approved') 
            ->when($monthNumber, function ($query) use ($monthNumber, $year) {
                return $query->whereMonth('tanggal', $monthNumber)
                             ->whereYear('tanggal', $year);
            })
            ->get();

        return view('cetak.cetak-disiplin', [
            'disiplin' => $disciplines,
            'month' => $month
        ]);
    }

    public function edit(string $id)
    {
        $students = Siswa::all();
        $disiplin = Disiplin::findOrFail($id);
        
        return view('tambah.edit-disiplin', [
            'disiplin' => $disiplin,
            'today' => date('Y-m-d'),
            'siswa' => $students
        ]);
    }

    public function update(Request $request, string $id)
    {
        $disiplin = Disiplin::findOrFail($id);

        $validatedData = $request->validate([
            "siswa_id" => 'required|exists:siswas,id',
            "masalah" => 'required',
            "tanggal" => 'required',
            "keterangan" => 'required',
            "foto" => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($disiplin->foto) {
                Storage::disk('public')->delete($disiplin->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('fotoBuktiDisiplin', 'public');
        }

        $disiplin->update($validatedData);

        return redirect()->route('disiplin.index')->with('success', 'Data Berhasil Diperbarui');
    }

    public function destroy(string $id)
    {
        $disiplin = Disiplin::findOrFail($id);
        if ($disiplin->foto) {
            Storage::disk('public')->delete($disiplin->foto);
        }
        $disiplin->delete();
        
        return redirect()->route('disiplin.index')->with('success', 'Data Berhasil Dihapus');
    }

    public function pendingValidasi()
    {
        $disciplines = Disiplin::with(['siswa', 'pelapor'])
            ->where('status_validasi', 'Pending')
            ->get();

        return view('waka.disiplin-approval', [
            'disciplines' => $disciplines
        ]);
    }

    public function approve($id)
    {
        if (!auth()->user()->hasRole('Waka Kesiswaan')) {
            abort(403, 'Unauthorized action.');
        }

        $disiplin = Disiplin::findOrFail($id);
        $disiplin->update([
            'status_validasi' => 'Approved',
            'validator_id' => auth()->id()
        ]);
        return back()->with('success', 'Laporan disetujui.');
    }

    public function reject($id)
    {
        if (!auth()->user()->hasRole('Waka Kesiswaan')) {
            abort(403, 'Unauthorized action.');
        }

        $disiplin = Disiplin::findOrFail($id);
        $disiplin->update([
            'status_validasi' => 'Rejected',
            'validator_id' => auth()->id()
        ]);
        return back()->with('success', 'Laporan ditolak.');
    }

    public function updateStts(Request $request, $id)
    {
        $disiplin = Disiplin::findOrFail($id);
        $disiplin->update([
            'status_validasi' => $request->status,
            'validator_id' => auth()->id()
        ]);

        return redirect()->route('disiplin.index')->with('success', 'Status laporan disiplin berhasil diperbarui');
    }

    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DisiplinExport, 'Data_Disiplin_SMP43.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $month = $request->month; // Optional filter
        $query = Disiplin::with(['siswa', 'pelapor', 'validator']);
        
        if ($month) {
            $monthParts = explode('-', $month);
            if (count($monthParts) == 2) {
                $query->whereMonth('tanggal', $monthParts[1])
                      ->whereYear('tanggal', $monthParts[0]);
            }
        }
        
        $disiplin = $query->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('cetak.laporan-disiplin-pdf', compact('disiplin', 'month'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('Laporan_Disiplin_SMP43.pdf');
    }
}
