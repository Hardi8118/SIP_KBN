@extends('layouts.app')
@section('content')
<div class="my-2 sm:my-4">
    <div class="mb-3 sm:mb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Dashboard Admin</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Ringkasan aktivitas dan status pelayanan kelurahan.</p>
    </div>

    <div class="bg-blue-50 border border-blue-200 p-3.5 sm:p-5 rounded-2xl mb-4 sm:mb-6 shadow-sm">
        <h3 class="text-sm sm:text-base font-bold text-blue-900 mb-0.5">Panel Kendali Utama</h3>
        <p class="text-blue-800 text-xs sm:text-sm leading-relaxed">Anda memiliki wewenang untuk mengelola master data kependudukan, verifikasi permohonan surat warga, dan arsip penomoran surat keluar.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
        <a href="{{ route('admin.pengajuan.index') }}" class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 text-center shadow-sm hover:border-blue-500 hover:shadow-md transition group">
            <div class="text-3xl sm:text-5xl font-bold text-blue-600 mb-1 group-hover:scale-105 transition">{{ $countPengajuan }}</div>
            <div class="text-slate-600 font-semibold text-xs sm:text-sm">Pengajuan Masuk</div>
        </a>
        <a href="{{ route('admin.penduduk.index') }}" class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 text-center shadow-sm hover:border-blue-500 hover:shadow-md transition group">
            <div class="text-3xl sm:text-5xl font-bold text-emerald-600 mb-1 group-hover:scale-105 transition">{{ $countPenduduk }}</div>
            <div class="text-slate-600 font-semibold text-xs sm:text-sm">Data Penduduk</div>
        </a>
        <a href="{{ route('admin.surat_keluar.index') }}" class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 text-center shadow-sm hover:border-blue-500 hover:shadow-md transition group">
            <div class="text-3xl sm:text-5xl font-bold text-indigo-600 mb-1 group-hover:scale-105 transition">{{ $countSurat }}</div>
            <div class="text-slate-600 font-semibold text-xs sm:text-sm">Arsip Surat Keluar</div>
        </a>
    </div>
</div>
@endsection
