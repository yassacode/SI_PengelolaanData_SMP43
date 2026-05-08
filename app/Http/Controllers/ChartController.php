<?php

namespace App\Http\Controllers;

use App\Models\Disiplin;
use App\Models\Ekstrakurikuler;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data siswa dan grup berdasarkan bulan
        $disiplin = Disiplin::all();
        $students= Siswa::all();
        $ekskul = Ekstrakurikuler::all();
        $user = User::all();
        
        $monthlyCounts = $disiplin->groupBy(function ($disiplin) {
            return Carbon::parse($disiplin->tanggal)->format('m-y');
        })->map(function ($group) {
            return $group->count();
        });

        $labels = $monthlyCounts->keys();
        $values = $monthlyCounts->values();
        $totalStudents = $students->count();
        $totalDisiplin = $disiplin->count();
        $totalEkskul = $ekskul->count();
        $totalUser = $user->count();
        // Kirim data ke view
        return view('main.dashboard', [
            'labels' => $labels,
            'values' => $values,
            'totalStudents' => $totalStudents,
            'totalDisiplin' => $totalDisiplin,
            'totalEkskul' => $totalEkskul,
            'totalUser' => $totalUser,
        ]);
    }

    // method lain yang kosong telah dihapus
}
