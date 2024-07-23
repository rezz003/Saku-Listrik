<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanCustomerController extends Controller
{
    public function showDashboard(Request $request)
    {
        $userId = Auth::id();
        $search = $request->input('search');
        $tagihanData = collect();
        $searchPerformed = false;

        if ($search) {
            $tagihanData = Tagihan::with('pelanggan')
                ->whereHas('pelanggan', function ($query) use ($search) {
                    $query->where('nomor_kwh', 'LIKE', "%$search%");
                })
                ->get();
            $searchPerformed = true;
        }

        $historyPembayaran = Pembayaran::with('pelanggan')
            ->where('id_user', $userId)
            ->orderBy('created_at','desc')->paginate(10);

        return view('dashboard', compact('tagihanData', 'searchPerformed', 'historyPembayaran'));
    }

    // Redirect cekTagihan to showDashboard with the search parameter
    public function cekTagihan(Request $request)
    {
        return $this->showDashboard($request);
    }
}
