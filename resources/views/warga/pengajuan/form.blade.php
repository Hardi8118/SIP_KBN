@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto my-2 sm:my-4">
    <div class="mb-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800">{{ $jenisSurat->nama_surat }}</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Lengkapi formulir pengajuan di bawah ini.</p>
        </div>
        <a href="{{ route('warga.pengajuan.create') }}" class="text-blue-600 hover:underline text-xs sm:text-sm font-semibold">&larr; Kembali ke Pilihan Surat</a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 border border-red-200 p-3 rounded-xl mb-4 text-xs sm:text-sm shadow-sm">
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-4 sm:p-7 border border-slate-200 rounded-2xl shadow-sm">
        <form action="{{ route('warga.pengajuan.store', $jenisSurat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="flex flex-col sm:flex-row sm:items-center mb-3 gap-1 sm:gap-4">
                <label class="font-semibold text-slate-700 sm:w-1/3 text-xs sm:text-sm">NIK</label>
                <input type="text" value="{{ $penduduk->nik }}" class="w-full sm:w-2/3 border-slate-300 border rounded-xl p-2 sm:p-2.5 bg-slate-50 text-slate-500 text-xs sm:text-sm" readonly>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:items-center mb-3 gap-1 sm:gap-4">
                <label class="font-semibold text-slate-700 sm:w-1/3 text-xs sm:text-sm">Nama Lengkap</label>
                <input type="text" value="{{ $penduduk->nama_lengkap }}" class="w-full sm:w-2/3 border-slate-300 border rounded-xl p-2 sm:p-2.5 bg-slate-50 text-slate-500 text-xs sm:text-sm" readonly>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center mb-3 gap-1 sm:gap-4">
                <label class="font-semibold text-slate-700 sm:w-1/3 text-xs sm:text-sm">Jenis Kelamin</label>
                <div class="w-full sm:w-2/3 flex gap-4">
                    <label class="flex items-center gap-2 text-slate-600 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200 w-full text-xs sm:text-sm">
                        <input type="radio" checked disabled class="text-blue-600"> {{ $penduduk->jenis_kelamin }}
                    </label>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center mb-3 gap-1 sm:gap-4">
                <label class="font-semibold text-slate-700 sm:w-1/3 text-xs sm:text-sm">Tempat / Tgl Lahir</label>
                <input type="text" value="{{ $penduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('d-m-Y') }}" class="w-full sm:w-2/3 border-slate-300 border rounded-xl p-2 sm:p-2.5 bg-slate-50 text-slate-500 text-xs sm:text-sm" readonly>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-start mb-3 gap-1 sm:gap-4">
                <label class="font-semibold text-slate-700 sm:w-1/3 text-xs sm:text-sm sm:pt-2">Alamat</label>
                <textarea class="w-full sm:w-2/3 border-slate-300 border rounded-xl p-2 sm:p-2.5 bg-slate-50 text-slate-500 text-xs sm:text-sm" rows="2" readonly>{{ $penduduk->alamat }}</textarea>
            </div>

            @if(isset($dynamicVariables) && count($dynamicVariables) > 0)
                <div class="pt-4 border-t border-slate-200 mt-4 mb-4">
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 mb-1">Informasi Tambahan</h3>
                    <p class="text-xs text-slate-500 mb-3">Lengkapi informasi berikut sesuai kebutuhan format surat.</p>
                    
                    @foreach($dynamicVariables as $var)
                        <div class="flex flex-col sm:flex-row sm:items-center mb-3 gap-1 sm:gap-4">
                            <label class="font-semibold text-slate-700 sm:w-1/3 text-xs sm:text-sm">{{ ucwords(str_replace('_', ' ', $var)) }}</label>
                            <input type="text" name="{{ $var }}" class="w-full sm:w-2/3 border-slate-300 border rounded-xl p-2 sm:p-2.5 text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required placeholder="Masukkan {{ ucwords(str_replace('_', ' ', $var)) }}">
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-start mb-5 gap-1 sm:gap-4 pt-3 border-t border-slate-100">
                <label class="font-semibold text-slate-700 sm:w-1/3 text-xs sm:text-sm sm:pt-1">Unggah Berkas <span class="block text-xs font-normal text-slate-500 mt-0.5">Syarat: {{ $jenisSurat->syarat }}</span></label>
                <div class="w-full sm:w-2/3">
                    <input type="file" name="file_persyaratan" class="w-full border-slate-300 border rounded-xl p-2 bg-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500" required>
                    <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white font-bold py-2.5 px-8 rounded-xl hover:bg-blue-700 shadow transition-all active:scale-95 text-xs sm:text-sm">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>
@endsection