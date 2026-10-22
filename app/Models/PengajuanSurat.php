<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PengajuanSurat extends Model {
    protected $fillable = ['nik', 'id_jenis_surat', 'tanggal_pengajuan', 'file_persyaratan', 'status', 'data_tambahan'];
    public function dataPenduduk() {
        return $this->belongsTo(DataPenduduk::class, 'nik', 'nik');
    }
    public function jenisSurat() {
        return $this->belongsTo(JenisSurat::class, 'id_jenis_surat');
    }
}