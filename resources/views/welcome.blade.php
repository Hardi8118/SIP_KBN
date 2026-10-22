@extends('layouts.app')
@section('content')
<div class="bg-blue-600 text-white rounded-2xl sm:rounded-3xl p-6 sm:p-10 my-2 sm:my-4 shadow-md text-center">
    <div class="inline-block border border-white/80 rounded-full px-3 sm:px-4 py-0.5 sm:py-1 mb-3 sm:mb-4 text-xs font-semibold tracking-wider uppercase">
        Pelayanan Digital 24/7
    </div>
    
    <h1 class="text-2xl sm:text-4xl md:text-5xl font-bold mb-3 sm:mb-4 leading-tight">
        Layanan Administrasi<br>Terpadu & Transparan
    </h1>
    
    <p class="text-sm sm:text-lg mb-6 sm:mb-8 max-w-2xl mx-auto opacity-95 leading-relaxed">
        Sistem Informasi Kelurahan Berok Nipah mempermudah warga dalam mengurus dokumen pengantar dan surat keterangan secara efisien, praktis, dan tanpa antrean panjang.
    </p>
    
    <div class="flex flex-col sm:flex-row justify-center gap-2.5 sm:gap-4">
        <a href="{{ route('warga.pengajuan.create') }}" class="bg-white text-blue-600 font-bold py-2.5 sm:py-3 px-6 sm:px-8 rounded-xl hover:bg-slate-100 transition shadow-sm text-sm sm:text-base">
            Mulai Pengajuan Surat
        </a>
        <a href="{{ route('warga.riwayat') }}" class="border-2 border-white text-white font-bold py-2.5 sm:py-3 px-6 sm:px-8 rounded-xl hover:bg-white hover:text-blue-600 transition text-sm sm:text-base">
            Lihat Riwayat Pengajuan
        </a>
    </div>
</div>
@endsection
