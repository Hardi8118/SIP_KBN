<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DataPenduduk extends Model {
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nik', 'no_kk', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'pekerjaan', 'alamat'];
    public function user() {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }
    public function pengajuanSurat() {
        return $this->hasMany(PengajuanSurat::class, 'nik', 'nik');
    }
}