@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto my-2 sm:my-4">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2.5">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Riwayat Pengajuan Surat</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Daftar permohonan surat yang telah Anda ajukan.</p>
        </div>
        <a href="{{ route('warga.pengajuan.create') }}" class="bg-green-600 text-white font-bold py-2 px-4 rounded-xl hover:bg-green-700 shadow-sm transition active:scale-95 text-xs sm:text-sm self-stretch sm:self-auto text-center">+ Buat Pengajuan Baru</a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-3 rounded-xl mb-4 border border-green-200 text-xs sm:text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-left whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600">
                <tr>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm text-center">ID</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Jenis Surat</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm text-center">Tgl Pengajuan</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pengajuans as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-center font-mono text-xs sm:text-sm text-slate-500">{{ $p->id }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 font-semibold text-slate-800 text-xs sm:text-sm">{{ $p->jenisSurat->nama_surat }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-center text-slate-600 text-xs sm:text-sm">{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d/m/Y') }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-center">
                        @if($p->status == 'Menunggu')
                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-xs px-2.5 py-1 rounded-full font-semibold border border-amber-200">⏳ Menunggu</span>
                        @elseif($p->status == 'Disetujui')
                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 text-xs px-2.5 py-1 rounded-full font-semibold border border-green-200">✅ Disetujui</span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 text-xs px-2.5 py-1 rounded-full font-semibold border border-red-200">❌ Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-6 px-4 text-center text-slate-400 text-xs sm:text-sm">Belum ada riwayat pengajuan surat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
