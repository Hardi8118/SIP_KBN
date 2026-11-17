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
                        @php $berkasList = $p->berkas_persyaratan_list; @endphp
                        @if(count($berkasList) === 1 && !empty($berkasList[0]['file']))
                            <a href="{{ Storage::url($berkasList[0]['file']) }}" target="_blank" class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-lg text-xs font-semibold hover:bg-blue-600 hover:text-white transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span>Tinjau (1 Berkas)</span>
                            </a>
                        @elseif(count($berkasList) > 1)
                            <button type="button" onclick="document.getElementById('modalBerkas{{ $p->id }}').classList.remove('hidden')" class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-lg text-xs font-semibold hover:bg-blue-600 hover:text-white transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>Tinjau ({{ count($berkasList) }} Berkas)</span>
                            </button>
                        @else
                            <span class="text-slate-400 text-xs italic">Tidak ada berkas</span>
                        @endif
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

                @if(count($berkasList) > 1)
                <!-- Modal Tinjau Berkas -->
                <div id="modalBerkas{{ $p->id }}" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 z-50 overflow-y-auto">
                    <div class="bg-white p-4 sm:p-6 rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto border border-slate-200 shadow-xl my-auto text-left">
                        <div class="flex items-start justify-between mb-4 border-b border-slate-100 pb-3">
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-slate-800">Berkas Persyaratan Pemohon</h3>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $p->dataPenduduk->nama_lengkap ?? 'Warga' }} &bull; {{ $p->jenisSurat->nama_surat }}</p>
                            </div>
                            <button type="button" onclick="document.getElementById('modalBerkas{{ $p->id }}').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="space-y-2.5 my-3">
                            @foreach($berkasList as $idxB => $b)
                                <div class="flex items-center justify-between p-3 rounded-xl border border-slate-200 bg-slate-50/70 hover:bg-slate-50 transition gap-3">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center flex-shrink-0">{{ $loop->iteration }}</span>
                                        <div class="truncate">
                                            <div class="text-xs sm:text-sm font-semibold text-slate-800 truncate">{{ $b['nama'] ?? 'Berkas ' . ($idxB + 1) }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono truncate">{{ basename($b['file'] ?? '') }}</div>
                                        </div>
                                    </div>
                                    @if(!empty($b['file']))
                                        <a href="{{ Storage::url($b['file']) }}" target="_blank" class="flex-shrink-0 bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-700 transition flex items-center gap-1 shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            Buka File
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Belum ada</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end pt-3 border-t border-slate-100 mt-4">
                            <button type="button" onclick="document.getElementById('modalBerkas{{ $p->id }}').classList.add('hidden')" class="bg-slate-100 text-slate-700 px-4 py-2 rounded-xl font-bold hover:bg-slate-200 transition text-xs sm:text-sm">Tutup</button>
                        </div>
                    </div>
                </div>
                @endif
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