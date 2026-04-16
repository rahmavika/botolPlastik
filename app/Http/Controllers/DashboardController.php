<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}