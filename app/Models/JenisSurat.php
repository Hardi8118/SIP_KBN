<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $fillable = [
        'nama_surat',
        'kode_surat',
        'syarat',
        'form_isian',
        'template_dokumen',
    ];

    /**
     * Mengambil daftar persyaratan dalam bentuk array yang rapi.
     * Mendukung format JSON, pemisah baris baru, koma, maupun kata 'dan'.
     */
    public function getDaftarSyaratAttribute(): array
    {
        if (empty($this->syarat)) {
            return [];
        }

        // Coba decode JSON
        $decoded = json_decode($this->syarat, true);
        if (is_array($decoded)) {
            return array_values(array_filter(array_map('trim', $decoded)));
        }

        // Jika dipisahkan baris baru
        if (str_contains($this->syarat, "\n")) {
            return array_values(array_filter(array_map('trim', explode("\n", $this->syarat))));
        }

        // Jika dipisahkan tanda koma
        if (str_contains($this->syarat, ',')) {
            return array_values(array_filter(array_map('trim', explode(',', $this->syarat))));
        }

        // Jika dipisahkan kata ' dan ' (seperti data dummy lama)
        if (str_contains(strtolower($this->syarat), ' dan ')) {
            return array_values(array_filter(array_map('trim', preg_split('/\s+dan\s+/i', $this->syarat))));
        }

        return [trim($this->syarat)];
    }
}