<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengesahan Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Laporan (Menunggu Pengesahan)</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">No</th>
                                    <th class="py-2 px-4 border-b text-left">Jenis Laporan</th>
                                    <th class="py-2 px-4 border-b text-left">Periode</th>
                                    <th class="py-2 px-4 border-b text-center">Status</th>
                                    <th class="py-2 px-4 border-b text-center">Tgl Disahkan</th>
                                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporans as $laporan)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-4 border-b">{{ $laporan->jenis_laporan }}</td>
                                    <td class="py-2 px-4 border-b">{{ $laporan->periode }}</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        @if($laporan->status_kepsek == 'Pending')
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Approved</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">{{ $laporan->tgl_disahkan ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b text-center space-x-2">
                                        @if($laporan->status_kepsek == 'Pending')
                                        <form action="{{ route('laporan.approve', $laporan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1 rounded shadow-sm text-sm">✓ Sahkan</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada data yang ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
