<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PelangganController extends Controller
{
    /**
     * index
     *
     * @return void
     */

     // Metode untuk menampilkan daftar pelanggan dengan filter daya
     public function index(Request $request) : View
     {
      
        // Mengambil semua tarif
         $tarifs = Tarif::all();
         // Mengambil parameter daya dari request
         $daya = $request->input('daya');

         // Membuat query untuk mengambil data pelanggan beserta tarifnya
        $query = Pelanggan::with('tarif');

         // Jika ada parameter daya, tambahkan kondisi ke query
        if ($daya) {
            $query->whereHas('tarif', function($query) use ($daya) {
                $query->where('daya', $daya);
            });
        }

        // Menjalankan query dan mengambil data pelanggan
        $pelangganData = $query->get();

        // Mengambil semua daya yang tersedia untuk filter
        $dayaOptions = Tarif::pluck('daya')->unique();

         return view('pelanggan.index', compact('pelangganData','tarifs','dayaOptions'));
     }

     public function store(Request $request)
     {
        $pelanggan = new Pelanggan;
        $pelanggan->username = $request->username;
        $pelanggan->nomor_kwh = $request->nomor_kwh;
        $pelanggan->nama_pelanggan = $request->nama_pelanggan;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->id_tarif = $request->id_tarif;
        $pelanggan->save();

        return redirect('/pelanggan')->with('success', 'Pelanggan berhasil Dibuat.');;

     }

     public function destroy($id)
     {
         try {
             $pelanggan = Pelanggan::findOrFail($id);
             $pelanggan->delete();
     
             return redirect('/pelanggan')->with('success', 'Pelanggan berhasil dihapus.');
         } catch (\Exception $e) {
             return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pelanggan.');
         }
     } 

     public function update(Request $request, $id)
     {

        Log::info('Update request data', $request->all());

     $request->validate([
         'username' => 'required',
         'nomor_kwh' => 'required|numeric',
         'nama_pelanggan' => 'required',
         'alamat' => 'required',
         'id_tarif' => 'required|numeric',
     ]);
 
     try {
         $pelanggan = Pelanggan::findOrFail($id);
         Log::info('Pelanggan ditemukan', ['pelanggan' => $pelanggan]);
         $pelanggan->username = $request->username;
         $pelanggan->nomor_kwh = $request->nomor_kwh;
         $pelanggan->nama_pelanggan = $request->nama_pelanggan;
         $pelanggan->alamat = $request->alamat;
         $pelanggan->id_tarif = $request->id_tarif;
         $pelanggan->save();
 
         Log::info('Data pelanggan diperbarui', ['pelanggan' => $pelanggan]);

         return redirect('/pelanggan')->with('success', 'Data pelanggan berhasil diperbarui.');
     } catch (\Exception $e) {
        Log::error('Error memperbarui data pelanggan', ['exception' => $e]);
         return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data pelanggan.');
     }
     }
}
