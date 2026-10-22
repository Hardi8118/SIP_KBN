<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SuratKeluar extends Model {
    protected $primaryKey = 'no_surat';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['no_surat', 'id_pengajuan', 'id_jenis_surat'];
    public function pengajuanSurat() {
        return $this->belongsTo(PengajuanSurat::class, 'id_pengajuan');
    }
    public function jenisSurat() {
        return $this->belongsTo(JenisSurat::class, 'id_jenis_surat');
    }
}