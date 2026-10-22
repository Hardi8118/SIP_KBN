<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\DataPenduduk;
use App\Models\JenisSurat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'nik' => '1234567890123456',
            'password' => Hash::make('password'),
            'peran' => 'admin'
        ]);
        
        DataPenduduk::create([
            'nik' => $admin->nik,
            'no_kk' => '1371030000000001',
            'nama_lengkap' => 'Administrator',
            'tempat_lahir' => 'Padang',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'pekerjaan' => 'PNS',
            'alamat' => 'Kantor Kelurahan Berok Nipah'
        ]);

        // Create Warga
        $warga = User::create([
            'nik' => '9876543210987654',
            'password' => Hash::make('password'),
            'peran' => 'warga'
        ]);

        DataPenduduk::create([
            'nik' => $warga->nik,
            'no_kk' => '1371030711070236',
            'nama_lengkap' => 'Andi Warga',
            'tempat_lahir' => 'Padang',
            'tanggal_lahir' => '1995-05-05',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'pekerjaan' => 'Wiraswasta',
            'alamat' => 'Jl. Berok Nipah No. 10'
        ]);

        // Create Jenis Surat
        $surats = [
            'Surat Keterangan Tidak Mampu',
            'Surat Pengantar Nikah',
            'Surat Kematian',
            'Surat Keterangan Domisili',
            'Surat Keterangan Usaha',
            'Surat Keterangan Kelakuan Baik',
            'Surat Keterangan PBB',
            'Surat Keterangan Ahli Waris',
            'Surat Keterangan Hibah Tanah',
        ];

        foreach ($surats as $surat) {
            JenisSurat::create([
                'nama_surat' => $surat,
                'syarat' => 'Fotokopi KTP dan Kartu Keluarga'
            ]);
        }
    }
}
