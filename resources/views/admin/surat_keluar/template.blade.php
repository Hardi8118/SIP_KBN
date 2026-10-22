<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $surat->jenisSurat->nama_surat }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; margin: 0; padding: 20px; line-height: 1.5; font-size: 12pt; }
        .kop-surat { text-align: center; border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h1, .kop-surat h2, .kop-surat h3 { margin: 0; }
        .kop-surat h1 { font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat h2 { font-size: 14pt; font-weight: bold; }
        .kop-surat p { font-size: 10pt; margin: 5px 0 0 0; }
        .judul-surat { text-align: center; margin-bottom: 20px; }
        .judul-surat h3 { margin: 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; }
        .judul-surat p { margin: 0; font-size: 12pt; }
        .isi-surat { text-align: justify; }
        .tabel-biodata { margin-left: 30px; margin-bottom: 20px; }
        .tabel-biodata td { padding: 2px 5px; vertical-align: top; }
        .tabel-biodata td:first-child { width: 150px; }
        .ttd-container { width: 100%; margin-top: 50px; }
        .ttd-box { float: right; width: 300px; text-align: center; }
        .ttd-box p { margin: 0; }
        .ttd-box .nama-lurah { font-weight: bold; text-decoration: underline; margin-top: 70px; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>PEMERINTAH KOTA PADANG</h2>
        <h2>KECAMATAN PADANG BARAT</h2>
        <h1>KELURAHAN BEROK NIPAH</h1>
        <p>Jl. Berok Nipah No.1, Padang Barat, Kota Padang, Sumatera Barat 25118</p>
    </div>

    <div class="judul-surat">
        <h3>{{ $surat->jenisSurat->nama_surat }}</h3>
        <p>Nomor: {{ $surat->no_surat }}</p>
    </div>

    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini Lurah Berok Nipah, Kecamatan Padang Barat, Kota Padang, dengan ini menerangkan bahwa:</p>
        
        <table class="tabel-biodata">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td><b>{{ $surat->pengajuanSurat->dataPenduduk->nama_lengkap }}</b></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $surat->pengajuanSurat->dataPenduduk->nik }}</td>
            </tr>
            <tr>
                <td>Tempat, Tgl Lahir</td>
                <td>:</td>
                <td>{{ $surat->pengajuanSurat->dataPenduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($surat->pengajuanSurat->dataPenduduk->tanggal_lahir)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $surat->pengajuanSurat->dataPenduduk->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $surat->pengajuanSurat->dataPenduduk->alamat }}</td>
            </tr>
        </table>

        <p>Orang tersebut di atas benar-benar adalah warga yang berdomisili di Kelurahan Berok Nipah, Kecamatan Padang Barat, Kota Padang. Surat keterangan ini dibuat untuk keperluan pengurusan <b>{{ $surat->jenisSurat->nama_surat }}</b>.</p>
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>{!! nl2br(e($jabatan_ttd ?? 'Lurah Berok Nipah')) !!}</p>
            <div class="nama-lurah">{{ $nama_ttd ?? 'H. SYAMSURIZAL, S.Sos' }}</div>
            <p>NIP. {{ $nip_ttd ?? '19750817 200501 1 005' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
