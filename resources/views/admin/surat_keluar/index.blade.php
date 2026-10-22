@extends('layouts.app')
@section('content')
<div class="my-2 sm:my-4">
    <div class="mb-3 sm:mb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Arsip & Cetak Surat</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Daftar surat yang telah diverifikasi dan siap dicetak.</p>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-x-auto shadow-sm">
        <table class="min-w-full text-left whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600">
                <tr>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Nomor Surat</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Pemohon</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Jenis Surat</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($suratKeluars as $sk)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-800 font-semibold font-mono text-xs sm:text-sm">{{ $sk->no_surat }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4">
                        <div class="font-bold text-slate-800 text-xs sm:text-sm">{{ $sk->pengajuanSurat->dataPenduduk->nama_lengkap ?? 'Warga' }}</div>
                        <div class="text-[11px] text-slate-400 font-mono">{{ \Carbon\Carbon::parse($sk->pengajuanSurat->tanggal_pengajuan)->format('d/m/Y') }}</div>
                    </td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-700 font-medium text-xs sm:text-sm">{{ $sk->jenisSurat->nama_surat }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-center">
                        <!-- Tombol -->
                        <button onclick="document.getElementById('modalCetak{{ $loop->iteration }}').classList.remove('hidden')" class="inline-block bg-blue-600 text-white px-3 py-1.5 rounded-xl text-xs sm:text-sm font-bold shadow-sm hover:bg-blue-700 transition active:scale-95">
                            Cetak Dokumen
                        </button>

                        <!-- Modal Cetak -->
                        <div id="modalCetak{{ $loop->iteration }}" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 z-50 overflow-y-auto">
                            <div class="bg-white p-4 sm:p-6 rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto border border-slate-200 shadow-xl my-auto whitespace-normal text-left">
                                <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-4">Opsi Penandatangan</h3>
                                <form id="form_cetak_{{ $loop->iteration }}" action="{{ route('admin.surat_keluar.cetak', base64_encode($sk->no_surat)) }}" method="GET" target="_blank" onsubmit="setTimeout(() => document.getElementById('modalCetak{{ $loop->iteration }}').classList.add('hidden'), 500)">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Pilih Pejabat (Preset)</label>
                                            <select id="preset_ttd_{{ $sk->id }}" onchange="ubahPenandatangan('{{ $sk->id }}')" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 bg-white">
                                                <option value="lurah">Lurah Berok Nipah</option>
                                                <option value="sekretaris">Sekretaris Lurah</option>
                                                <option value="kasi">Kasi Pemerintahan</option>
                                                <option value="custom">-- Kustom / Ketik Manual --</option>
                                            </select>
                                        </div>
                                        <hr class="border-slate-100 my-1">
                                        <div>
                                            <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Jabatan Penandatangan</label>
                                            <textarea rows="2" name="jabatan_ttd" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required>Lurah Berok Nipah</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Nama Lengkap & Gelar</label>
                                            <input type="text" name="nama_ttd" value="H. SYAMSURIZAL, S.Sos" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required>
                                        </div>
                                        <div>
                                            <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">NIP</label>
                                            <input type="text" name="nip_ttd" value="19750817 200501 1 005" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required>
                                        </div>
                                    </div>
                                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 mt-5 pt-3 border-t border-slate-100">
                                        <button type="button" onclick="document.getElementById('modalCetak{{ $loop->iteration }}').classList.add('hidden')" class="w-full sm:w-auto bg-slate-100 text-slate-700 px-4 py-2 rounded-xl font-bold hover:bg-slate-200 transition text-xs sm:text-sm">Batal</button>
                                        <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-5 py-2 rounded-xl font-bold hover:bg-blue-700 shadow-sm transition text-xs sm:text-sm">
                                            Cetak
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-6 px-4 text-center text-slate-400 text-xs sm:text-sm">Belum ada arsip surat keluar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
function ubahPenandatangan(id) {
    const select = document.getElementById('preset_ttd_' + id);
    const form = document.getElementById('form_cetak_' + id);
    
    if (select.value === 'lurah') {
        form.jabatan_ttd.value = 'Lurah Berok Nipah';
        form.nama_ttd.value = 'H. SYAMSURIZAL, S.Sos';
        form.nip_ttd.value = '19750817 200501 1 005';
    } else if (select.value === 'sekretaris') {
        form.jabatan_ttd.value = 'a.n. Lurah Berok Nipah\nSekretaris Lurah';
        form.nama_ttd.value = 'NAMA SEKRETARIS, S.E';
        form.nip_ttd.value = '19800101 200501 2 001';
    } else if (select.value === 'kasi') {
        form.jabatan_ttd.value = 'a.n. Lurah Berok Nipah\nKasi Pemerintahan';
        form.nama_ttd.value = 'NAMA KASI, S.AP';
        form.nip_ttd.value = '19850101 201001 1 002';
    } else {
        form.jabatan_ttd.value = '';
        form.nama_ttd.value = '';
        form.nip_ttd.value = '';
    }
}
</script>
@endsection