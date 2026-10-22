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
        
        return view('warga.pengajuan.form', compact('jenisSurat', 'penduduk', 'dynamicVariables'));
    }

    public function pengajuanStore(Request $request, $id)
    {
        $request->validate([
            'file_persyaratan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        
        $jenisSurat = JenisSurat::findOrFail($id);
        
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

        $path = $request->file('file_persyaratan')->store('persyaratan', 'public');

        PengajuanSurat::create([
            'nik' => Auth::id(),
            'id_jenis_surat' => $id,
            'tanggal_pengajuan' => now(),
            'file_persyaratan' => $path,
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
