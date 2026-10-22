<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataPenduduk;
use App\Models\PengajuanSurat;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $countPengajuan = PengajuanSurat::count();
        $countPenduduk = DataPenduduk::count();
        $countSurat = SuratKeluar::count();
        
        return view('admin.dashboard', compact('countPengajuan', 'countPenduduk', 'countSurat'));
    }

    public function jenisSuratIndex()
    {
        $jenisSurats = \App\Models\JenisSurat::all();
        return view('admin.jenis_surat.index', compact('jenisSurats'));
    }

    public function jenisSuratStore(Request $request)
    {
        $request->validate([
            'nama_surat' => 'required|string',
            'kode_surat' => 'nullable|string',
            'syarat' => 'required|string',
            'template_dokumen' => 'nullable|file|mimes:docx|max:5120',
        ]);

        $path = null;
        $detectedFormIsian = $request->form_isian;
        
        if ($request->hasFile('template_dokumen')) {
            $path = $request->file('template_dokumen')->store('templates', 'public');
            $autoDetect = $this->extractDocxVariables($path);
            if ($autoDetect) {
                $detectedFormIsian = $autoDetect;
            }
        }

        \App\Models\JenisSurat::create([
            'nama_surat' => $request->nama_surat,
            'kode_surat' => $request->kode_surat ?? '400',
            'syarat' => $request->syarat,
            'form_isian' => $detectedFormIsian,
            'template_dokumen' => $path,
        ]);

        return back()->with('success', 'Jenis Surat berhasil ditambahkan.');
    }

    public function jenisSuratUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_surat' => 'required|string',
            'kode_surat' => 'nullable|string',
            'syarat' => 'required|string',
            'template_dokumen' => 'nullable|file|mimes:docx|max:5120',
        ]);

        $js = \App\Models\JenisSurat::findOrFail($id);
        $js->nama_surat = $request->nama_surat;
        $js->kode_surat = $request->kode_surat ?? '400';
        $js->syarat = $request->syarat;
        $js->form_isian = $request->form_isian;

        if ($request->hasFile('template_dokumen')) {
            if ($js->template_dokumen) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($js->template_dokumen);
            }
            $js->template_dokumen = $request->file('template_dokumen')->store('templates', 'public');
            
            $autoDetect = $this->extractDocxVariables($js->template_dokumen);
            if ($autoDetect) {
                $js->form_isian = $autoDetect;
            }
        }

        $js->save();

        return back()->with('success', 'Jenis Surat berhasil diperbarui.');
    }

    public function jenisSuratDestroy($id)
    {
        $js = \App\Models\JenisSurat::findOrFail($id);
        if ($js->template_dokumen) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($js->template_dokumen);
        }
        $js->delete();
        return back()->with('success', 'Jenis Surat berhasil dihapus.');
    }

    public function pendudukIndex()
    {
        $penduduks = DataPenduduk::all();
        return view('admin.penduduk.index', compact('penduduks'));
    }

    public function pendudukStore(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:users,nik',
            'nama_lengkap' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
        ]);

        $user = User::create([
            'nik' => $request->nik,
            'password' => Hash::make('password'),
            'peran' => 'warga',
        ]);

        DataPenduduk::create([
            'nik' => $user->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function pendudukDestroy($nik)
    {
        User::where('nik', $nik)->delete();
        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil dihapus.');
    }

    public function pengajuanIndex()
    {
        $pengajuans = PengajuanSurat::with(['jenisSurat', 'dataPenduduk'])->orderBy('created_at', 'desc')->get();
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    public function pengajuanVerifikasi(Request $request, $id)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);
        $request->validate(['status' => 'required|in:Menunggu,Disetujui,Ditolak']);
        
        $pengajuan->status = $request->status;
        $pengajuan->save();

        if ($request->status === 'Disetujui') {
            // Check if already in surat_keluar
            if (!SuratKeluar::where('id_pengajuan', $pengajuan->id)->exists()) {
                $tahun = date('Y');
                $bulanRomawi = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X', 11=>'XI', 12=>'XII'];
                $bulan = $bulanRomawi[date('n')];
                $kode = $pengajuan->jenisSurat->kode_surat ?? '400';
                $sequenceNum = \App\Models\SuratKeluar::whereYear('created_at', $tahun)->count() + 1;
                $sequence = str_pad($sequenceNum, 3, '0', STR_PAD_LEFT);
                $no_surat = "{$kode}/{$sequence}/KBN/PDG/{$bulan}/{$tahun}";
                
                // Cegah bentrok / duplikasi nomor urut (Error 1062)
                while (\App\Models\SuratKeluar::where('no_surat', $no_surat)->exists()) {
                    $sequenceNum++;
                    $sequence = str_pad($sequenceNum, 3, '0', STR_PAD_LEFT);
                    $no_surat = "{$kode}/{$sequence}/KBN/PDG/{$bulan}/{$tahun}";
                }
                
                SuratKeluar::create([
                    'no_surat' => $no_surat,
                    'id_pengajuan' => $pengajuan->id,
                    'id_jenis_surat' => $pengajuan->id_jenis_surat,
                ]);
            }
        }

        return redirect()->route('admin.pengajuan.index')->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function suratKeluarIndex()
    {
        $suratKeluars = SuratKeluar::with(['pengajuanSurat.dataPenduduk', 'jenisSurat'])->get();
        return view('admin.surat_keluar.index', compact('suratKeluars'));
    }
    
    public function suratKeluarCetak(Request $request, $no_surat_base64)
    {
        $no_surat = base64_decode($no_surat_base64);
        $surat = SuratKeluar::with(['pengajuanSurat.dataPenduduk', 'jenisSurat'])->where('no_surat', $no_surat)->firstOrFail();
        
        $nama_ttd = $request->nama_ttd ?? 'H. SYAMSURIZAL, S.Sos';
        $jabatan_ttd = $request->jabatan_ttd ?? 'Lurah Berok Nipah';
        $nip_ttd = $request->nip_ttd ?? '19750817 200501 1 005';
        
        if ($surat->jenisSurat->template_dokumen && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat->jenisSurat->template_dokumen)) {
            $templatePath = storage_path('app/public/' . $surat->jenisSurat->template_dokumen);
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);
            
            // 1. TTD
            $templateProcessor->setValue('nama_ttd', $nama_ttd);
            $templateProcessor->setValue('jabatan_ttd', str_replace("\n", "</w:t><w:br/><w:t>", htmlspecialchars($jabatan_ttd)));
            $templateProcessor->setValue('nip_ttd', $nip_ttd);
            
            // 2. Biodata Standar
            $templateProcessor->setValue('nama_lengkap', $surat->pengajuanSurat->dataPenduduk->nama_lengkap);
            $templateProcessor->setValue('nik', $surat->pengajuanSurat->dataPenduduk->nik);
            $templateProcessor->setValue('no_kk', $surat->pengajuanSurat->dataPenduduk->no_kk);
            $templateProcessor->setValue('agama', $surat->pengajuanSurat->dataPenduduk->agama);
            $templateProcessor->setValue('pekerjaan', $surat->pengajuanSurat->dataPenduduk->pekerjaan);
            $templateProcessor->setValue('pekerjan', $surat->pengajuanSurat->dataPenduduk->pekerjaan); // Mentoleransi typo
            $templateProcessor->setValue('tempat_lahir', $surat->pengajuanSurat->dataPenduduk->tempat_lahir);
            $templateProcessor->setValue('tanggal_lahir', \Carbon\Carbon::parse($surat->pengajuanSurat->dataPenduduk->tanggal_lahir)->translatedFormat('d F Y'));
            $templateProcessor->setValue('jenis_kelamin', $surat->pengajuanSurat->dataPenduduk->jenis_kelamin);
            $templateProcessor->setValue('alamat', $surat->pengajuanSurat->dataPenduduk->alamat);
            $templateProcessor->setValue('no_surat', $surat->no_surat);
            $templateProcessor->setValue('tanggal_cetak', \Carbon\Carbon::now()->translatedFormat('d F Y'));
            
            // 3. Data Tambahan
            if ($surat->pengajuanSurat->data_tambahan) {
                $extras = json_decode($surat->pengajuanSurat->data_tambahan, true);
                if (is_array($extras)) {
                    foreach ($extras as $key => $val) {
                        $templateProcessor->setValue($key, $val);
                    }
                }
            }
            
            // Save as Temp DOCX
            $fileName = 'Surat_' . str_replace('/', '_', $surat->no_surat);
            $tempDocx = storage_path('app/public/' . uniqid('temp_') . '.docx');
            $templateProcessor->saveAs($tempDocx);
            
            // KEMBALIKAN KE DOWNLOAD DOCX AGAR DESAIN 100% AMAN!
            return response()->download($tempDocx, $fileName . '.docx')->deleteFileAfterSend(true);
        }
        
        // Fallback default PDF jika tidak ada template Word
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.surat_keluar.template', compact('surat', 'nama_ttd', 'jabatan_ttd', 'nip_ttd'));
        return $pdf->stream('Surat_' . str_replace('/', '_', $surat->no_surat) . '.pdf');
    }
    private function extractDocxVariables($path)
    {
        $fullPath = storage_path('app/public/' . $path);
        $zip = new \ZipArchive;
        $variables = [];
        
        if ($zip->open($fullPath) === true) {
            // Baca isi dokumen utama (document.xml)
            $xml = $zip->getFromName('word/document.xml');
            if ($xml !== false) {
                // Hapus SEMUA tag XML yang memecah kata kunci
                $text = strip_tags($xml);
                // Cari format ${nama_variabel}
                preg_match_all('/(?:\$\{?|\{|\[)\s*([a-zA-Z0-9_]+)\s*(?:\}|\}|\])/', $text, $matches);
                if (!empty($matches[1])) {
                    $variables = array_unique($matches[1]);
                }
            }
            $zip->close();
        }
        
        $standard = ['nama_lengkap', 'nik', 'no_kk', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'pekerjaan', 'pekerjan', 'alamat', 'no_surat', 'tanggal_cetak', 'nama_ttd', 'jabatan_ttd', 'nip_ttd'];
        $dynamic = array_diff($variables, $standard);
        
        return count($dynamic) > 0 ? implode(', ', $dynamic) : null;
    }
    public function scanDocx(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $zip = new \ZipArchive;
            $variables = [];
            
            if ($zip->open($file->getRealPath()) === true) {
                $xml = $zip->getFromName('word/document.xml');
                if ($xml !== false) {
                    $text = strip_tags($xml);
                    preg_match_all('/(?:\$\{?|\{|\[)\s*([a-zA-Z0-9_]+)\s*(?:\}|\}|\])/', $text, $matches);
                    if (!empty($matches[1])) {
                        $variables = array_unique($matches[1]);
                    }
                }
                $zip->close();
            }
            
            $standard = ['nama_lengkap', 'nik', 'no_kk', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'pekerjaan', 'pekerjan', 'alamat', 'no_surat', 'tanggal_cetak', 'nama_ttd', 'jabatan_ttd', 'nip_ttd'];
            $dynamic = array_diff($variables, $standard);
            
            if (count($dynamic) > 0) {
                return response()->json(['success' => true, 'variables' => implode(', ', $dynamic)]);
            }
        }
        return response()->json(['success' => false]);
    }
}


