<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index() : View
    {
        $customerData = User::where('role','customer')->get();
        return view('customer.index', compact('customerData'));
    }
}
