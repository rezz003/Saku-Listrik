<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TagihanController extends Controller
{
    public function index() : View{
        $tagihanData = Tagihan::with('pelanggan')->get();
        $pelangganData = Pelanggan::all();
        return view('tagihan.index', compact('tagihanData','pelangganData'));
    }

    private function calculate_jumlah_kwh($meteran_awal, $meteran_akhir){
        return $meteran_akhir - $meteran_awal;
    }

    private function calculate_total_tagihan($jumlah_kwh, $tarifperkwh)
    {
        return $jumlah_kwh * $tarifperkwh;
    }

    public function store(Request $request)
    {
    $request->validate([
        'id_pelanggan' => 'required',
        'tanggal_tagihan' => 'required|date',
        'id_penggunaan' => 'required', // tambahkan validasi untuk id_penggunaan
    ]);

    try {
        // Cek apakah sudah ada tagihan dengan status lunas untuk id_penggunaan ini
        $tagihanLunas = Tagihan::where('id_penggunaan', $request->id_penggunaan)
                                ->where('status', 'Lunas')
                                ->exists();

        if ($tagihanLunas) {
            return redirect()->back()->with('error', 'Tagihan sudah lunas untuk penggunaan ini.');
        }

        // Buat tagihan baru
        $penggunaan = Penggunaan::findOrFail($request->id_penggunaan);

        $jumlah_kwh = $this->calculate_jumlah_kwh($penggunaan->meteran_awal, $penggunaan->meteran_akhir);
        $tarif = $penggunaan->pelanggan->tarif->tarifperkwh;
        $total_tagihan = $this->calculate_total_tagihan($jumlah_kwh, $tarif);

        $tagihan = new Tagihan;
        $tagihan->id_penggunaan = $penggunaan->id_penggunaan;
        $tagihan->id_pelanggan = $request->id_pelanggan;
        $tagihan->tanggal_tagihan = $request->tanggal_tagihan;
        $tagihan->jumlah_kwh = $jumlah_kwh;
        $tagihan->total_tagihan = $total_tagihan;
        $tagihan->status = 'Dibuat'; 
        $tagihan->save();

        return redirect('/penggunaan')->with('success', 'Tagihan berhasil dibuat.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat tagihan.');
    }
    }

    

    public function search(Request $request)
    {
        $search = $request->input('search');

        $tagihanData = Tagihan::with('pelanggan')
            ->whereHas('pelanggan', function ($query) use ($search) {
                $query->where('nomor_kwh', 'LIKE', "%$search%");
            })
            ->get();

        $pelangganData = Pelanggan::all();

        return view('tagihan.index', compact('tagihanData', 'pelangganData'));
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'tanggal_tagihan' => 'required|date',
        'jumlah_kwh' => 'required|numeric',
        'total_tagihan' => 'required|numeric',
        'status' => 'required',
    ]);

    try {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->tanggal_tagihan = $request->tanggal_tagihan;
        $tagihan->jumlah_kwh = $request->jumlah_kwh;
        $tagihan->total_tagihan = $request->total_tagihan;
        $tagihan->status = $request->status;
        $tagihan->save();

        return redirect('/tagihan')->with('success', 'Tagihan berhasil diperbarui.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui tagihan.');
    }
    }

    public function destroy($id)
    {
        try {
            $tagihan = Tagihan::findOrFail($id);
            $tagihan->delete();
    
            return redirect('/tagihan')->with('success', 'Tagihan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus tagihan.');
        }
    } 

}
