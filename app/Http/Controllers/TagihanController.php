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
        $tagihanData = Tagihan::with('pelanggan')->orderBy('created_at', 'desc')
        ->paginate(10);
        $pelangganData = Pelanggan::all();
        return view('tagihan.index', compact('tagihanData','pelangganData'));
    } 

    public function search(Request $request)
    {
        $search = $request->input('search');

        $tagihanData = Tagihan::with('pelanggan')
            ->whereHas('pelanggan', function ($query) use ($search) {
                $query->where('nomor_kwh', 'LIKE', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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

    // public function destroy($id)
    // {
    //     try {
    //         $tagihan = Tagihan::findOrFail($id);
    //         $tagihan->delete();
    
    //         return redirect('/tagihan')->with('success', 'Tagihan berhasil dihapus.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus tagihan.');
    //     }
    // } 

}
