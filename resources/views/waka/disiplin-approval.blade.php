<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Validasi Kedisiplinan Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Laporan Pelanggaran (Menunggu Validasi)</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Tanggal</th>
                                    <th class="py-2 px-4 border-b text-left">Nama Siswa</th>
                                    <th class="py-2 px-4 border-b text-left">Pelapor (Guru BK)</th>
                                    <th class="py-2 px-4 border-b text-left">Masalah / Kasus</th>
                                    <th class="py-2 px-4 border-b text-center">Status</th>
                                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Contoh Data Statis / Nanti diganti foreach -->
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">2026-05-08</td>
                                    <td class="py-2 px-4 border-b">Budi Santoso</td>
                                    <td class="py-2 px-4 border-b">Bpk. Andi</td>
                                    <td class="py-2 px-4 border-b">Terlambat masuk jam pelajaran pertama</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
                                    </td>
                                    <td class="py-2 px-4 border-b text-center space-x-2">
                                        <form action="#" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1 rounded shadow-sm text-sm">✓ Approve</button>
                                        </form>
                                        <form action="#" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-1 rounded shadow-sm text-sm">✕ Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
