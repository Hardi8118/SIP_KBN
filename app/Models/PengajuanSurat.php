<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    protected $fillable = [
        'nik',
        'id_jenis_surat',
        'tanggal_pengajuan',
        'file_persyaratan',
        'status',
        'data_tambahan',
    ];

    public function dataPenduduk()
    {
        return $this->belongsTo(DataPenduduk::class, 'nik', 'nik');
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'id_jenis_surat');
    }

    /**
     * Mengambil daftar berkas persyaratan yang telah diunggah.
     * Mengembalikan array of array: [['nama' => '...', 'file' => '...'], ...]
     */
    public function getBerkasPersyaratanListAttribute(): array
    {
        if (empty($this->file_persyaratan)) {
            return [];
        }

        $decoded = json_decode($this->file_persyaratan, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        return [
            [
                'nama' => 'Berkas Persyaratan',
                'file' => $this->file_persyaratan,
            ]
        ];
    }
}