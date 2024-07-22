<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranCustomerController extends Controller
{
    public function create($id)
    {
        $tagihan = Tagihan::with('pelanggan')->findOrFail($id);
        return view('pembayaran', compact('tagihan'));
    }

    // Metode untuk pembayaran Customer
    public function store(Request $request)
    {
        // Validasi data request
        $validated = $request->validate([
            'id_tagihan' => 'required|exists:tagihan,id_tagihan',
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'id_user' => 'required|exists:users,id',
            'tanggal_pembayaran' => 'required|date',
            'biaya_admin' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // upload bukti pembayaran dan menyimpannya ke folder bukti_pembayaran
        $buktiPembayaran = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        // Membuat data pembayaran baru
        Pembayaran::create([
            'id_tagihan' => $validated['id_tagihan'],
            'id_pelanggan' => $validated['id_pelanggan'],
            'id_user' => $validated['id_user'],
            'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
            'biaya_admin' => $validated['biaya_admin'],
            'total_bayar' => $validated['total_bayar'],
            'bukti_pembayaran' => $buktiPembayaran,
        ]);

        // Update status tagihan
        $tagihan = Tagihan::findOrFail($validated['id_tagihan']);
        $tagihan->status = 'Proses';
        $tagihan->save();

        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil dilakukan!');
    }

}
