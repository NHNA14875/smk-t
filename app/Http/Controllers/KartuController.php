<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuTertelan;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class KartuController extends Controller
{
    public function dashboard()
    {
        // 1. Ambil data asli dari MySQL (Kecuali yang sudah diambil/dimusnahkan)
        $kartu = KartuTertelan::whereNotIn('status', ['Diambil', 'Dimusnahkan'])->get();

        // 2. Hitung otomatis sisa waktu dari tanggal masuk ke deadline
        foreach($kartu as $k) {
            $k->sisa_hari = (int) Carbon::now()->diffInDays(Carbon::parse($k->deadline), false);
        }

        $kritisCount = $kartu->where('sisa_hari', '<=', 3)->count();

        // 3. Kirim ke tampilan Blade
        return view('kartu.dashboard', compact('kartu', 'kritisCount'));
    }

    public function simpan(Request $request)
    {
        // Validasi dan simpan data kartu baru dari Satpam
        $request->validate([
            'nomor_kartu' => 'required',
            'nama_nasabah' => 'required',
            'lokasi_atm' => 'required',
            'lokasi_simpan' => 'required',
        ]);

        KartuTertelan::create([
            'id' => (string) Str::uuid(),
            'nomor_kartu' => $request->nomor_kartu,
            'nama_nasabah' => $request->nama_nasabah,
            'lokasi_atm' => $request->lokasi_atm,
            'lokasi_simpan' => $request->lokasi_simpan,
            'tanggal_masuk' => Carbon::now(),
            'deadline' => Carbon::now()->addDays(7),
            'status' => 'Disimpan',
            'input_oleh' => Auth::id(),
        ]);

        return redirect('/input')->with('success', 'Data kartu tertelan berhasil disimpan!');
    }

    public function updateStatus(Request $request, $id)
    {
        // Cari kartu berdasarkan ID dan perbarui statusnya
        $kartu = KartuTertelan::findOrFail($id);
        $kartu->status = $request->status;
        $kartu->save();

        return redirect()->back();
    }

    public function arsip()
    {
        // Ambil data yang sudah selesai
        $arsip = KartuTertelan::whereIn('status', ['Diambil', 'Dimusnahkan'])->get();
        
        foreach($arsip as $a) {
            $a->tanggal_selesai = Carbon::parse($a->updated_at)->format('d M Y');
            $a->tanggal_masuk = Carbon::parse($a->tanggal_masuk)->format('d M Y');
            $a->status_akhir = $a->status;
        }
        
        return view('kartu.arsip', compact('arsip'));
    }

    public function rekap()
    {
        $stats = (object)[
            'masuk' => KartuTertelan::count(),
            'diambil' => KartuTertelan::where('status', 'Diambil')->count(),
            'dimusnahkan' => KartuTertelan::where('status', 'Dimusnahkan')->count()
        ];
        
        $grafikAtm = [
            (object)['nama' => 'ATM Center', 'jumlah' => 2, 'persentase' => 80, 'warna' => 'var(--teal)']
        ];
        $waktu = (object)['rata_rata' => 1, 'tercepat' => 1, 'terlama' => 1];

        return view('kartu.rekap', compact('stats', 'grafikAtm', 'waktu'));
    }
}