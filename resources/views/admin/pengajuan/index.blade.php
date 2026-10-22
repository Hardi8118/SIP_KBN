@extends('layouts.app')
@section('content')
<div class="my-2 sm:my-4">
    <div class="mb-3 sm:mb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Verifikasi Pengajuan</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Daftar permohonan surat keterangan dari warga.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-3 rounded-xl mb-4 border border-green-200 text-xs sm:text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl overflow-x-auto shadow-sm">
        <table class="min-w-full text-left whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600">
                <tr>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Pemohon</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Jenis Surat</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Tanggal</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm text-center">Berkas</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm text-center">Status / Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pengajuans as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4">
                        <div class="font-bold text-slate-800 text-xs sm:text-sm">{{ $p->dataPenduduk->nama_lengkap ?? 'Warga' }}</div>
                        <div class="text-[11px] text-slate-400 font-mono">NIK: {{ $p->nik }}</div>
                    </td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-700 font-medium text-xs sm:text-sm">{{ $p->jenisSurat->nama_surat }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-600 text-xs sm:text-sm">{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d M Y') }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-center">
                        <a href="{{ Storage::url($p->file_persyaratan) }}" target="_blank" class="inline-block bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-lg text-xs font-semibold hover:bg-blue-600 hover:text-white transition">Tinjau</a>
                    </td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-center">
                        <form action="{{ route('admin.pengajuan.verifikasi', $p->id) }}" method="POST" class="inline-block">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="border border-slate-300 rounded-lg py-1 px-2 text-xs font-semibold bg-white focus:ring-2 focus:ring-blue-500 cursor-pointer @if($p->status=='Menunggu') text-amber-700 bg-amber-50/50 @elseif($p->status=='Disetujui') text-green-700 bg-green-50/50 @else text-red-700 bg-red-50/50 @endif">
                                <option value="Menunggu" {{ $p->status == 'Menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                                <option value="Disetujui" {{ $p->status == 'Disetujui' ? 'selected' : '' }}>✅ Disetujui</option>
                                <option value="Ditolak" {{ $p->status == 'Ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 px-4 text-center text-slate-400 text-xs sm:text-sm">Belum ada pengajuan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection