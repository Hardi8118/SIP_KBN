<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('pengajuan_surats', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16);
            $table->foreignId('id_jenis_surat')->constrained('jenis_surats')->onDelete('cascade');
            $table->date('tanggal_pengajuan');
            $table->string('file_persyaratan')->nullable();
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
            $table->foreign('nik')->references('nik')->on('data_penduduks')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('pengajuan_surats');
    }
};