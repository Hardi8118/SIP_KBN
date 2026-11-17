<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function pengajuanCreate()
    {
        $jenisSurats = JenisSurat::all();
        return view('warga.pengajuan.create', compact('jenisSurats'));
    }

    public function pengajuanForm($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $penduduk = Auth::user()->dataPenduduk;
        
        $dynamicVariables = [];
        if ($jenisSurat->form_isian) {
            $vars = explode(',', $jenisSurat->form_isian);
            foreach ($vars as $v) {
                if(trim($v) != '') {
                    $dynamicVariables[] = trim(strtolower(str_replace(' ', '_', $v)));
                }
            }
        }

        $daftarSyarat = $jenisSurat->daftar_syarat;
        if (count($daftarSyarat) === 0) {
            $daftarSyarat = ['Berkas Persyaratan'];
        }
        
        return view('warga.pengajuan.form', compact('jenisSurat', 'penduduk', 'dynamicVariables', 'daftarSyarat'));
    }

    public function pengajuanStore(Request $request, $id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        
        $request->validate([
            'berkas_persyaratan' => 'nullable|array',
            'berkas_persyaratan.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_persyaratan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        
        $dataTambahan = [];
        if ($jenisSurat->form_isian) {
            $vars = explode(',', $jenisSurat->form_isian);
            foreach ($vars as $v) {
                $key = trim(strtolower(str_replace(' ', '_', $v)));
                if ($key != '') {
                    $dataTambahan[$key] = $request->input($key);
                }
            }
        }

        $storedFiles = [];
        if ($request->hasFile('berkas_persyaratan')) {
            foreach ($request->file('berkas_persyaratan') as $idx => $file) {
                if ($file && $file->isValid()) {
                    $namaSyarat = $request->input("nama_syarat.$idx") ?? ("Persyaratan " . ($idx + 1));
                    $path = $file->store('persyaratan', 'public');
                    $storedFiles[] = [
                        'nama' => $namaSyarat,
                        'file' => $path,
                    ];
                }
            }
        } elseif ($request->hasFile('file_persyaratan')) {
            $path = $request->file('file_persyaratan')->store('persyaratan', 'public');
            $storedFiles[] = [
                'nama' => 'Berkas Persyaratan',
                'file' => $path,
            ];
        }

        $daftarSyarat = $jenisSurat->daftar_syarat;
        if (empty($storedFiles) || (!empty($daftarSyarat) && count($storedFiles) < count($daftarSyarat) && !$request->hasFile('file_persyaratan'))) {
            return back()->withErrors(['berkas_persyaratan' => 'Harap unggah seluruh berkas persyaratan yang diminta secara lengkap.'])->withInput();
        }

        PengajuanSurat::create([
            'nik' => Auth::id(),
            'id_jenis_surat' => $id,
            'tanggal_pengajuan' => now(),
            'file_persyaratan' => json_encode($storedFiles),
            'status' => 'Menunggu',
            'data_tambahan' => count($dataTambahan) > 0 ? json_encode($dataTambahan) : null,
        ]);

        return redirect()->route('warga.riwayat')->with('success', 'Pengajuan surat berhasil dikirim.');
    }

    public function riwayat()
    {
        $pengajuans = PengajuanSurat::where('nik', Auth::id())->with('jenisSurat')->orderBy('created_at', 'desc')->get();
        return view('warga.riwayat', compact('pengajuans'));
    }
}
