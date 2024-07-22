<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Penggunaan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenggunaanController extends Controller
{
    

    public function index() : View{
        $penggunaanData = Penggunaan::with('pelanggan')->get();
        $pelangganData = Pelanggan::all();
        return view('penggunaan.index',compact('penggunaanData','pelangganData'));
    }

    public function store(Request $request)
     {
        $penggunaan = new Penggunaan;
        $penggunaan->id_pelanggan = $request->id_pelanggan;
        $penggunaan->tanggal_penggunaan = $request->tanggal_penggunaan;
        $penggunaan->meteran_awal = $request->meteran_awal;
        $penggunaan->meteran_akhir = $request->meteran_akhir;
        $penggunaan->save();

        return redirect('/penggunaan');

     }
}
