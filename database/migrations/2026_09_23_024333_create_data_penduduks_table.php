<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('data_penduduks', function (Blueprint $table) {
            $table->string('nik', 16)->primary();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat');
            $table->timestamps();
            $table->foreign('nik')->references('nik')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('data_penduduks');
    }
};