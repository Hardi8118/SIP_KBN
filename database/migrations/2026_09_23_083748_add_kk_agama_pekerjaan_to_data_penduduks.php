<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('data_penduduks', function (Blueprint $table) {
            $table->string('no_kk', 20)->nullable()->after('nik');
            $table->string('agama', 50)->nullable()->after('jenis_kelamin');
            $table->string('pekerjaan', 100)->nullable()->after('agama');
        });
    }
    public function down(): void {
        Schema::table('data_penduduks', function (Blueprint $table) {
            $table->dropColumn(['no_kk', 'agama', 'pekerjaan']);
        });
    }
};