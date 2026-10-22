<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->string('no_surat')->primary();
            $table->foreignId('id_pengajuan')->constrained('pengajuan_surats')->onDelete('cascade');
            $table->foreignId('id_jenis_surat')->constrained('jenis_surats')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('surat_keluars');
    }
};