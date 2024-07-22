<?php

namespace App\Http\Controllers;

use App\Events\PenggunaanCreated;
use App\Models\Pelanggan;
use App\Models\Penggunaan;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * [Description PenggunaanController]
 */
class PenggunaanController extends Controller
{
    

    /**
     * @return View
     */
    public function index() : View{
        $penggunaanData = Penggunaan::with('pelanggan')->orderBy('created_at', 'desc')
        ->paginate(10);
        $pelangganData = Pelanggan::all();
        return view('penggunaan.index',compact('penggunaanData','pelangganData'));
    }

    /**
     * @param Request $request
     * 
     * @return [type]
     */
    public function store(Request $request)
     {
        $penggunaan = new Penggunaan;
        $penggunaan->id_pelanggan = $request->id_pelanggan;
        $penggunaan->tanggal_penggunaan = $request->tanggal_penggunaan;
        $penggunaan->meteran_awal = $request->meteran_awal;
        $penggunaan->meteran_akhir = $request->meteran_akhir;
        $penggunaan->save();

        // event(new PenggunaanCreated($penggunaan));

        return redirect('/penggunaan')->with('success', 'Penggunaan dan tagihan berhasil dibuat');

     }

     public function destroy($id){
        try{

            $penggunaan = Penggunaan::findOrFail($id);
            $penggunaan->delete();
    
            return redirect('/penggunaan')->with('success', 'Penggunaan berhasil dihapus.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus Penggunaan.');
        }
     }
}
