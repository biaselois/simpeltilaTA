<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Jadwal;
use App\Models\BeritaAcara;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
{
    $jumlahPermohonan = Permohonan::count();
    $jumlahJadwal = Jadwal::count();
    $jumlahBeritaAcara = BeritaAcara::count();
    $jumlahUser = User::count();
    $jumlahUser = User::where('role', 'petugas')->count();
    $jadwalMenunggu = Jadwal::with('petugas')->where('status', 'menunggu')->get();

     $dataPerBulan = Jadwal::selectRaw('MONTH(tanggal_tinjau) as bulan, COUNT(*) as total')
        ->where('status', 'Selesai')
        ->groupByRaw('MONTH(tanggal_tinjau)')
        ->pluck('total', 'bulan');

          $dataGrafik = [];
    for ($i = 1; $i <= 12; $i++) {
        $dataGrafik[] = $dataPerBulan[$i] ?? 0;
    }

    return view('dashboard', compact(
        'jumlahPermohonan',
        'jumlahJadwal',
        'jumlahBeritaAcara',
        'jumlahUser',
        'jadwalMenunggu',
        'dataGrafik'
    ));
}
}
