<?php

namespace App\Http\Controllers;

use App\Models\Disiplin;
use App\Models\Siswa;
use App\Http\Requests\DisiplinRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DisiplinExport;
use Exception;

class DisiplinController extends Controller
{
    /**
     * Display a listing of disciplinary records.
     */
    public function index(Request $request): View
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
                $carbon = Carbon::parse($month);
                $query->whereMonth('tanggal', $carbon->month)
                      ->whereYear('tanggal', $carbon->year);
            })
            ->get();

        return view('main.disiplin', [
            'disiplin' => $disciplines,
            'search' => $search,
            'month' => $month,
        ]);
    }

    /**
     * Show form for creating a new record.
     */
    public function create(): View
    {
        $students = Siswa::all();
        return view('tambah.add-disiplin', [
            'today' => now()->format('Y-m-d'),
            'siswa' => $students
        ]);
    }

    /**
     * Store a newly created record.
     */
    public function store(DisiplinRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();
        $validatedData['status_validasi'] = Disiplin::STATUS_PENDING;

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('fotoBuktiDisiplin', 'public');
        }

        Disiplin::create($validatedData);

        return redirect()->route('disiplin.index')->with('success', 'Data Pelanggaran Berhasil Dilaporkan');
    }

    /**
     * Display report for printing.
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

        $disciplines = Disiplin::with(['siswa', 'pelapor'])
            ->where('status_validasi', Disiplin::STATUS_APPROVED) 
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

    /**
     * Show form for editing.
     */
    public function edit(string $id): View
    {
        $students = Siswa::all();
        $disiplin = Disiplin::findOrFail($id);
        
        return view('tambah.edit-disiplin', [
            'disiplin' => $disiplin,
            'today' => now()->format('Y-m-d'),
            'siswa' => $students
        ]);
    }

    /**
     * Update the record.
     */
    public function update(DisiplinRequest $request, string $id): RedirectResponse
    {
        $disiplin = Disiplin::findOrFail($id);
        $validatedData = $request->validated();

        if ($request->hasFile('foto')) {
            if ($disiplin->foto) {
                Storage::disk('public')->delete($disiplin->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('fotoBuktiDisiplin', 'public');
        }

        $disiplin->update($validatedData);

        return redirect()->route('disiplin.index')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Delete the record.
     */
    public function destroy(string $id): RedirectResponse
    {
        $disiplin = Disiplin::findOrFail($id);
        if ($disiplin->foto) {
            Storage::disk('public')->delete($disiplin->foto);
        }
        $disiplin->delete();
        
        return redirect()->route('disiplin.index')->with('success', 'Data Berhasil Dihapus');
    }

    /**
     * Show pending validation list (Waka).
     */
    public function pendingValidasi(): View
    {
        $disciplines = Disiplin::with(['siswa', 'pelapor'])
            ->where('status_validasi', Disiplin::STATUS_PENDING)
            ->get();

        return view('waka.disiplin-approval', [
            'disciplines' => $disciplines
        ]);
    }

    /**
     * Approve a record (Waka).
     */
    public function approve(int $id): RedirectResponse
    {
        if (!auth()->user()->hasRole('Waka Kesiswaan')) {
            abort(403, 'Unauthorized action.');
        }

        $disiplin = Disiplin::findOrFail($id);
        $disiplin->update([
            'status_validasi' => Disiplin::STATUS_APPROVED,
            'validator_id' => auth()->id()
        ]);
        return back()->with('success', 'Laporan disetujui.');
    }

    /**
     * Reject a record (Waka).
     */
    public function reject(int $id): RedirectResponse
    {
        if (!auth()->user()->hasRole('Waka Kesiswaan')) {
            abort(403, 'Unauthorized action.');
        }

        $disiplin = Disiplin::findOrFail($id);
        $disiplin->update([
            'status_validasi' => Disiplin::STATUS_REJECTED,
            'validator_id' => auth()->id()
        ]);
        return back()->with('success', 'Laporan ditolak.');
    }

    /**
     * Manual status update.
     */
    public function updateStts(Request $request, int $id): RedirectResponse
    {
        $disiplin = Disiplin::findOrFail($id);
        $disiplin->update([
            'status_validasi' => $request->status,
            'validator_id' => auth()->id()
        ]);

        return redirect()->route('disiplin.index')->with('success', 'Status laporan disiplin berhasil diperbarui');
    }

    /**
     * Export to Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new \App\Exports\DisiplinExport, 'Data_Disiplin_SMP43.xlsx');
    }

    /**
     * Export to PDF.
     */
    public function exportPdf(Request $request)
    {
        $month = $request->month;
        $query = Disiplin::with(['siswa', 'pelapor', 'validator']);
        
        if ($month && $parts = explode('-', $month)) {
            if (count($parts) == 2) {
                $query->whereMonth('tanggal', $parts[1])
                      ->whereYear('tanggal', $parts[0]);
            }
        }
        
        $disiplin = $query->get();
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('cetak.laporan-disiplin-pdf', compact('disiplin', 'month'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('Laporan_Disiplin_SMP43.pdf');
    }
}
