<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Permohonan;
use App\Models\User;

class JadwalController extends Controller
{
    // Tampilkan semua jadwal
    public function index()
    {
        $data = Jadwal::with('permohonan', 'petugas')->get();
        return view('jadwal.index', compact('data'));
    }

    // Tampilkan form untuk tambah jadwal
   public function create(Request $request)
{
    $permohonans = Permohonan::all();
    $selectedPermohonanId = $request->permohonan_id;
    $petugas = User::where('role', 'petugas')->get();
    return view('jadwal.create', compact('permohonans', 'petugas', 'selectedPermohonanId'));
}


    // Simpan data jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'permohonan_id' => 'required|unique:jadwals,permohonan_id',
            'tanggal_tinjau' => 'required|date',
            // 'lokasi' => 'required|string|max:255',
            'petugas_id' => 'required|array',
            'petugas_id.*' => 'exists:users,id',
        ]);

        // Simpan data utama jadwal
        $permohonan = \App\Models\Permohonan::findOrFail($request->permohonan_id);

        $jadwal = Jadwal::create([
            'permohonan_id' => $request->permohonan_id,
            'tanggal_tinjau' => $request->tanggal_tinjau,
            'lokasi' => $permohonan->alamat_objek,
        ]);

        // Simpan relasi ke tabel pivot
        $jadwal->petugas()->attach($request->petugas_id);
        $permohonan = Permohonan::find($request->permohonan_id);
        $permohonan->status = 'Dijadwalkan';
        $permohonan->save();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::with('permohonan', 'petugas')->findOrFail($id);
        $permohonans = Permohonan::all();
        $petugas = User::where('role', 'petugas')->get();

        return view('jadwal.edit', compact('jadwal', 'permohonans', 'petugas'));
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'permohonan_id' => 'required|exists:permohonans,id',
            'tanggal_tinjau' => 'required|date',
            'petugas_id' => 'required|array',
            'petugas_id.*' => 'exists:users,id',
        ]);

        // Cari jadwal yang mau di-update
        $jadwal = Jadwal::findOrFail($id);

        // Update data jadwal
        $jadwal->update([
            'permohonan_id' => $request->permohonan_id,
            'tanggal_tinjau' => $request->tanggal_tinjau,
            // 'lokasi' => $request->lokasi, // kalau ada lokasi tinggal aktifkan
        ]);

        // Update relasi pivot petugas
        $jadwal->petugas()->sync($request->petugas_id);



        // Redirect dengan pesan sukses
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|string|in:pending,diproses,selesai' // Sesuaikan dengan status yang kamu pakai
        ]);

        // Cari data jadwal berdasarkan ID
        $jadwal = Jadwal::findOrFail($id);

        // Update status
        $jadwal->status = $request->status;
        $jadwal->save();

        // Redirect kembali ke halaman jadwal dengan pesan sukses
        return redirect()->route('jadwal.index')->with('success', 'Status berhasil diperbarui.');
    }




    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->petugas()->detach(); // hapus relasi di tabel pivot
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function petugas()
{
    $data = User::where('role', 'petugas')
        ->withCount(['jadwals as total_tinjau' => function ($query) {
            $query->where('status', 'Selesai');
        }])
        ->get();

    return view('report.petugas', compact('data'));
}
public function reportDetail($id, Request $request)
{
    $user = User::findOrFail($id);

    $jadwals = $user->jadwals()
        ->where('status', 'Selesai')
        ->with('permohonan')
        ->get();

         if ($request->filled('start_date') && $request->filled('end_date')) {
        $jadwals->whereBetween('tanggal_tinjau', [$request->start_date, $request->end_date]);
    }

    return view('report.detail-report', compact('user', 'jadwals'));
}

}
