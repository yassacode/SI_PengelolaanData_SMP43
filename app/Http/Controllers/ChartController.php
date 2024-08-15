<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Extracurricular;
use App\Models\Student;
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
        $disiplin = Discipline::all();
        $students= Student::all();
        $ekskul = Extracurricular::all();
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
