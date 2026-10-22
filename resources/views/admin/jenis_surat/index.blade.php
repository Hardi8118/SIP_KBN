@extends('layouts.app')
@section('content')
<div class="my-2 sm:my-4">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2.5">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Master Jenis Surat</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Kelola format dokumen dan kustomisasi formulir surat.</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-green-600 text-white px-4 py-2 rounded-xl font-bold shadow-sm hover:bg-green-700 transition active:scale-95 text-xs sm:text-sm w-full sm:w-auto">
            + Tambah Jenis Surat
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-3 rounded-xl mb-4 border border-green-200 text-xs sm:text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 text-red-600 border border-red-200 p-3 rounded-xl mb-4 text-xs sm:text-sm shadow-sm">
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <!-- Info Template -->
    <div class="bg-blue-50 border border-blue-200 p-3.5 sm:p-4 rounded-2xl mb-4 text-blue-900 text-xs sm:text-sm shadow-sm leading-relaxed">
        <strong>Info Template Word (.docx):</strong> Anda dapat mengunggah template surat format Word kustom.
        Sisipkan kata kunci berikut di dalam Word agar diganti otomatis dengan data warga saat dicetak:
        <div class="flex flex-wrap gap-1.5 mt-2">
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${nama_lengkap}</code>
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${nik}</code>
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${no_kk}</code>
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${tempat_lahir}</code>
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${tanggal_lahir}</code>
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${jenis_kelamin}</code>
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${agama}</code>
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${pekerjaan}</code>
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${alamat}</code>
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${no_surat}</code>
            <code class="bg-white px-2 py-0.5 rounded shadow-sm font-mono text-xs font-bold text-blue-700">${tanggal_cetak}</code>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div id="modalTambah" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 z-50 overflow-y-auto">
        <div class="bg-white p-4 sm:p-6 rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto border border-slate-200 shadow-xl my-auto">
            <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-4">Tambah Jenis Surat</h3>
            <form action="{{ route('admin.jenis_surat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-3 text-left">
                    <div>
                        <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Nama Surat</label>
                        <input type="text" name="nama_surat" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required placeholder="Contoh: Surat Keterangan Usaha">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Nomor / Kode Surat</label>
                        <input type="text" name="kode_surat" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 400.10.4">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Persyaratan</label>
                        <textarea name="syarat" rows="2" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required placeholder="Contoh: KTP dan Kartu Keluarga"></textarea>
                    </div>
                    <div>
                        <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Kolom Isian Tambahan (Opsional)</label>
                        <input type="text" name="form_isian" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" placeholder="Contoh: keperluan, nama_usaha">
                        <p class="text-[11px] text-green-600 mt-0.5 font-semibold">✨ Pilih file .docx di bawah, sistem otomatis mengisi kotak ini.</p>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Template Word (.docx) <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <input type="file" name="template_dokumen" accept=".docx" onchange="scanTemplate(this)" class="w-full border-slate-300 border rounded-lg bg-white mt-1 p-1.5 text-xs focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 mt-5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="w-full sm:w-auto bg-slate-100 text-slate-700 px-4 py-2 rounded-xl font-bold hover:bg-slate-200 transition text-xs sm:text-sm">Batal</button>
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-5 py-2 rounded-xl font-bold hover:bg-blue-700 shadow-sm transition text-xs sm:text-sm">Simpan Jenis Surat</button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-x-auto shadow-sm">
        <table class="min-w-full text-left whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600">
                <tr>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">No</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Nama Surat</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Kode/No</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Persyaratan</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Template</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($jenisSurats as $js)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-800 font-mono text-xs sm:text-sm">{{ $loop->iteration }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-800 font-semibold text-xs sm:text-sm">{{ $js->nama_surat }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-600 font-mono text-xs sm:text-sm">{{ $js->kode_surat ?? '-' }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-600 max-w-[200px] truncate text-xs sm:text-sm" title="{{ $js->syarat }}">{{ $js->syarat }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4">
                        @if($js->template_dokumen)
                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded-full text-xs font-bold border border-blue-200">
                                Kustom (.docx)
                            </span>
                        @else
                            <span class="inline-block bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full text-xs font-semibold border border-slate-200">Default (PDF)</span>
                        @endif
                    </td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                            <!-- Tombol Ubah -->
                            <button onclick="document.getElementById('modalUbah{{ $js->id }}').classList.remove('hidden')" class="bg-blue-50 text-blue-600 border border-blue-200 px-2.5 py-1 rounded-lg text-xs font-semibold hover:bg-blue-600 hover:text-white transition">Ubah</button>
                            
                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.jenis_surat.destroy', $js->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="bg-red-50 text-red-600 border border-red-200 px-2.5 py-1 rounded-lg text-xs font-semibold hover:bg-red-600 hover:text-white transition" onclick="return confirm('Hapus jenis surat ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Modal Ubah -->
                <div id="modalUbah{{ $js->id }}" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 z-50 overflow-y-auto">
                    <div class="bg-white p-4 sm:p-6 rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto border border-slate-200 shadow-xl my-auto">
                        <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-4">Ubah Jenis Surat</h3>
                        <form action="{{ route('admin.jenis_surat.update', $js->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="space-y-3 text-left">
                                <div>
                                    <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Nama Surat</label>
                                    <input type="text" name="nama_surat" value="{{ $js->nama_surat }}" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Nomor / Kode Surat</label>
                                    <input type="text" name="kode_surat" value="{{ $js->kode_surat }}" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Persyaratan</label>
                                    <textarea name="syarat" rows="2" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required>{{ $js->syarat }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Kolom Isian Tambahan</label>
                                    <input type="text" name="form_isian" value="{{ $js->form_isian }}" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" placeholder="Contoh: keperluan, nama_usaha">
                                    <p class="text-[11px] text-green-600 mt-0.5 font-semibold">✨ Pilih file .docx di bawah, sistem otomatis mengisi kotak ini.</p>
                                </div>
                                <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                    <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Ganti Template Word (.docx) <span class="text-slate-400 font-normal">(Bila Perlu)</span></label>
                                    <input type="file" name="template_dokumen" accept=".docx" onchange="scanTemplate(this)" class="w-full border-slate-300 border rounded-lg bg-white mt-1 p-1.5 text-xs focus:ring-2 focus:ring-blue-500">
                                    @if($js->template_dokumen)
                                        <p class="text-xs text-green-600 font-semibold mt-1">✓ Template saat ini sudah terpasang.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 mt-5 pt-3 border-t border-slate-100">
                                <button type="button" onclick="document.getElementById('modalUbah{{ $js->id }}').classList.add('hidden')" class="w-full sm:w-auto bg-slate-100 text-slate-700 px-4 py-2 rounded-xl font-bold hover:bg-slate-200 transition text-xs sm:text-sm">Batal</button>
                                <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-5 py-2 rounded-xl font-bold hover:bg-blue-700 shadow-sm transition text-xs sm:text-sm">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" class="py-6 px-4 text-center text-slate-400 text-xs sm:text-sm">Belum ada master jenis surat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection