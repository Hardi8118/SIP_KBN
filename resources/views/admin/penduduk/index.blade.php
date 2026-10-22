@extends('layouts.app')
@section('content')
<div class="my-2 sm:my-4">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2.5">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Data Penduduk</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Daftar master kependudukan Kelurahan Berok Nipah.</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-green-600 text-white px-4 py-2 rounded-xl font-bold shadow-sm hover:bg-green-700 transition active:scale-95 text-xs sm:text-sm w-full sm:w-auto">
            + Tambah Penduduk
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-3 rounded-xl mb-4 border border-green-200 text-xs sm:text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Modal Tambah -->
    <div id="modalTambah" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 z-50 overflow-y-auto">
        <div class="bg-white p-4 sm:p-6 rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto border border-slate-200 shadow-xl my-auto">
            <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-4">Tambah Data Penduduk</h3>
            <form action="{{ route('admin.penduduk.store') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">NIK</label>
                        <input type="text" name="nik" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required maxlength="16" placeholder="16 digit NIK">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required placeholder="Nama lengkap">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required placeholder="Kota kelahiran">
                        </div>
                        <div>
                            <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 bg-white" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-700 font-semibold mb-1 text-xs sm:text-sm">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" class="w-full border-slate-300 border rounded-xl p-2 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required placeholder="Alamat tinggal"></textarea>
                    </div>
                </div>
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 mt-5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="w-full sm:w-auto bg-slate-100 text-slate-700 px-4 py-2 rounded-xl font-bold hover:bg-slate-200 transition text-xs sm:text-sm">Batal</button>
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-5 py-2 rounded-xl font-bold hover:bg-blue-700 shadow-sm transition text-xs sm:text-sm">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-x-auto shadow-sm">
        <table class="min-w-full text-left whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600">
                <tr>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">NIK</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Nama Lengkap</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">TTL</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Kelamin</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm">Alamat</th>
                    <th class="py-2.5 px-3 sm:py-3 sm:px-4 font-bold text-xs sm:text-sm text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($penduduks as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-800 font-mono text-xs sm:text-sm">{{ $p->nik }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-800 font-medium text-xs sm:text-sm">{{ $p->nama_lengkap }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-600 text-xs sm:text-sm">{{ $p->tempat_lahir }}, {{ $p->tanggal_lahir }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-600 text-xs sm:text-sm">{{ $p->jenis_kelamin }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-slate-600 max-w-xs truncate text-xs sm:text-sm" title="{{ $p->alamat }}">{{ $p->alamat }}</td>
                    <td class="py-2.5 px-3 sm:py-3 sm:px-4 text-center">
                        <form action="{{ route('admin.penduduk.destroy', $p->nik) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="bg-red-50 text-red-600 border border-red-200 px-2.5 py-1 rounded-lg text-xs font-semibold hover:bg-red-600 hover:text-white transition" onclick="return confirm('Hapus data penduduk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 px-4 text-center text-slate-400 text-xs sm:text-sm">Belum ada data penduduk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection