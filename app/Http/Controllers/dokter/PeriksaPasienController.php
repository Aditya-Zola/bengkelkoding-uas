<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        // Opsional: Hanya tampilkan obat yang stoknya > 0
        $obats = Obat::where('stok', '>', 0)->get();

        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|integer',
        ]);

        $obatIds = json_decode($request->obat_json, true);

        // --- 1. VALIDASI STOK SEBELUM DISIMPAN ---
        // Cek apakah ada obat yang stoknya sudah habis tapi tetap dipilih
        foreach ($obatIds as $idObat) {
            $obatCek = Obat::find($idObat);
            if ($obatCek && $obatCek->stok <= 0) {
                return back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan! Stok obat "' . $obatCek->nama_obat . '" sudah habis.');
            }
        }

        // --- 2. SIMPAN DATA PERIKSA (HEADER) ---
        $periksa = Periksa::create([
            'id_daftar_poli' => $request->id_daftar_poli,
            'tgl_periksa' => now(),
            'catatan' => $request->catatan,
            'biaya_periksa' => $request->biaya_periksa + 150000,
        ]);

        // --- 3. SIMPAN DETAIL & KURANGI STOK ---
        foreach ($obatIds as $idObat) {
            $obat = Obat::find($idObat);

            if ($obat) {
                // Simpan ke tabel detail
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $idObat,
                ]);

                // Kurangi stok obat
                $obat->decrement('stok');
            }
        }

        return redirect()->route('periksa-pasien.index')
            ->with('success', 'Data periksa berhasil disimpan dan stok obat telah diperbarui.');
    }
}
