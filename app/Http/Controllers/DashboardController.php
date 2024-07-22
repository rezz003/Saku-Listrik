<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pembayaran = Pembayaran::where('id_user', $user->id)->with('pelanggan')->get();

        return view('dashboard', compact('pembayaran'));
    }
}
