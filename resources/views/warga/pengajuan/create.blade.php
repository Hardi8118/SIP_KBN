@extends('layouts.app')
@section('content')
<div class="bg-blue-50/80 p-4 sm:p-7 rounded-2xl border border-blue-100 shadow-sm my-2 sm:my-4">
    <div class="text-center mb-4 sm:mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Pilih Jenis Surat</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Pilih surat keterangan yang ingin Anda ajukan permohonannya.</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
        @foreach($jenisSurats as $surat)
        <a href="{{ route('warga.pengajuan.form', $surat->id) }}" class="bg-white border border-slate-200 rounded-xl p-3.5 sm:p-5 text-center shadow-sm hover:shadow-md hover:border-blue-500 transition-all flex items-center justify-center min-h-[75px] sm:min-h-[90px] group active:scale-[0.98]">
            <span class="text-slate-800 font-semibold text-xs sm:text-sm group-hover:text-blue-600 transition">{{ $surat->nama_surat }}</span>
        </a>
        @endforeach
    </div>
</div>
@endsection
