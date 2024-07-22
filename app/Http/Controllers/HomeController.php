<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // jumlah data tarif
        $tarifCount = Tarif::count();

        //jumlah data pelanggan
        $pelangganCount = Pelanggan::count();

        //jumlah data penggunaan
        $penggunaanCount = Penggunaan::count();
        
        //jumlah data pembayaran
        $pembayaranCount = Pembayaran::count();
        
        //jumlah data penggunaan
        $tagihanCount = Tagihan::count();
        
        //jumlah data customer
        $customerCount = User::where('role','customer')->count();
        return view('admin.dashboard', compact('tarifCount','pelangganCount','penggunaanCount','pembayaranCount','tagihanCount','customerCount'));
    }
}
