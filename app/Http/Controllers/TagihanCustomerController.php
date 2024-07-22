<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanCustomerController extends Controller
{
    public function cekTagihan(Request $request)
    {
        $search = $request->input('search');
        $userId = Auth::id();
        $tagihanData = collect();
        $searchPerformed = false;
        $historyPembayaran = Pembayaran::with('pelanggan')
                                ->where('id_user', $userId)
                                ->get();


        if ($search) {
            $tagihanData = Tagihan::with('pelanggan')
                ->whereHas('pelanggan', function ($query) use ($search) {
                    $query->where('nomor_kwh', 'LIKE', "%$search%");
                })
                ->get();
            $searchPerformed = true;
        }

        return view('dashboard', compact('tagihanData', 'searchPerformed','historyPembayaran'));
    }

    public function showDashboard()
    {
        $userId = Auth::id();
        $tagihanData = collect();
        $searchPerformed = false;
        $historyPembayaran = Pembayaran::with('pelanggan')
                                ->where('id_user', $userId)
                                ->get();

        return view('dashboard', compact('tagihanData', 'searchPerformed', 'historyPembayaran'));
    }
}
