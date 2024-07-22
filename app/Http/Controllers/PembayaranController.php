<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    public function index() : View{
        $pembayaranData = Pembayaran::all();
        return view('pembayaran.index',compact('pembayaranData'));
    }

    public function destroy($id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);
            $pembayaran->delete();
    
            return redirect('/pembayaran')->with('success', 'Pembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pembayaran.');
        }
    }
    
    public function confirm($id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);
            $tagihan = Tagihan::findOrFail($pembayaran->id_tagihan);
            $tagihan->status = 'Lunas';
            $tagihan->save();

            return redirect('/pembayaran')->with('success', 'Tagihan berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengkonfirmasi tagihan.');
        }
    }
}
