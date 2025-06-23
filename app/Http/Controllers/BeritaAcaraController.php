<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BeritaAcaraController extends Controller
{
    public function index(Request $request)
    {
        $data = BeritaAcara::with('jadwal')->get();
        $query =BeritaAcara::with(['jadwal.permohonan', 'jadwal.petugas']);

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
    }

    if ($request->filled('search')) {
        $search = $request->search;

        $query->whereHas('jadwal.permohonan', function ($q) use ($search) {
            $q->where('nama_wp', 'like', '%' . $search . '%')
              ->orWhere('nop', 'like', '%' . $search . '%');
        });
    }

    $data = $query->orderByDesc('tanggal')->get();
        return view('berita-acara.index', compact('data'));
    }

    public function create(Request $request)
    {
        $jadwals = Jadwal::with('permohonan')->get();
        $selectedJadwalId = $request->query('jadwal_id');
        return view('berita-acara.create', compact('jadwals', 'selectedJadwalId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_id' => 'required|unique:berita_acaras,jadwal_id',
            'tanggal' => 'required|date',
            'Hasil' => 'required|string',
            'Rekomendasi' => 'required|string',
            'dokumentasi' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'Signature_WP' => 'required|string',
        ]);

        try {
            $jadwal = Jadwal::with('permohonan')->findOrFail($validated['jadwal_id']);
            $permohonan = $jadwal->permohonan;

            if (!$permohonan) {
                return back()->withErrors(['error' => 'Permohonan tidak ditemukan untuk jadwal ini.']);
            }

            $fileName = $request->file('dokumentasi')->store('dokumentasi', 'public');
            $base64 = $request->input('Signature_WP');

            $image = base64_decode(explode(',', $base64)[1]);

            $filename = uniqid() . '_signature.png';
            $path = storage_path('app/public/ttd_wp/' . $filename);
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0777, true);
            }
            file_put_contents($path, $image);

            BeritaAcara::create([
                'jadwal_id' => $validated['jadwal_id'],
                'tanggal' => $validated['tanggal'],
                'Nama_WP' => $permohonan->nama_wp,
                'Alamat_WP' => $permohonan->alamat_wp,
                'NOP' => $permohonan->nop,
                'Alamat_OP' => $permohonan->alamat_objek,
                'Tujuan' => $permohonan->tujuan,
                'Hasil' => $validated['Hasil'],
                'Rekomendasi' => $validated['Rekomendasi'],
                'dokumentasi' => $fileName,
                'Signature_WP' => 'ttd_wp/' . $filename,
            ]);

            // Update status jadwal menjadi selesai
            $jadwal->status = 'selesai';
            $jadwal->save();

            return redirect()->route('berita-acara.index')->with('success', 'Berita Acara berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $berita = BeritaAcara::with('jadwal')->findOrFail($id);
        $jadwals = Jadwal::all();

        return view('berita-acara.edit', compact('berita', 'jadwals'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal' => 'required|date',
            'Hasil' => 'required|string',
            'Rekomendasi' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,png,pdf',
            'Signature_WP' => 'nullable|file|mimes:png,jpg',
        ]);

        $berita = BeritaAcara::findOrFail($id);

        if ($request->hasFile('dokumentasi')) {
            $fileName = $request->file('dokumentasi')->store('dokumentasi', 'public');
            $berita->dokumentasi = $fileName;
        }

        if ($request->hasFile('Signature_WP')) {
            $ttdWp = $request->file('Signature_WP')->store('ttd_wp', 'public');
            $berita->Signature_WP = $ttdWp;
        }

        $berita->jadwal_id = $validated['jadwal_id'];
        $berita->tanggal = $validated['tanggal'];
        $berita->Hasil = $validated['Hasil'];
        $berita->Rekomendasi = $validated['Rekomendasi'];

        $berita->save();

        return redirect()->route('berita-acara.index')->with('success', 'Berita Acara berhasil diperbarui.');
    }


    public function show($id)
    {
        $data = BeritaAcara::with('jadwal')->findOrFail($id);
        return view('berita-acara.show', compact('data'));
    }

    public function validateKasi($id)
    {
        $ba = BeritaAcara::findOrFail($id);
        $ba->Validasi_Kasi = 'validated_kasi_signature.png';
        $ba->save();

        return back()->with('success', 'Validasi Kasi berhasil.');
    }

    public function exportPDF($id)
    {
            \Carbon\Carbon::setLocale('id');

    $beritaAcara = BeritaAcara::with('jadwal')->findOrFail($id);
     $beritaAcara->tanggal_formatted = \Carbon\Carbon::parse($beritaAcara->tanggal)->translatedFormat('d F Y');


        $pdf = PDF::loadView('berita-acara.surat', compact('beritaAcara'));
        return $pdf->download('berita-acara-' . $id . '.pdf');
    }
    public function cetak($id)
    {
        $data = BeritaAcara::with('jadwal.petugas')->findOrFail($id);
        $data = BeritaAcara::with('jadwal.permohonan')->findOrFail($id);
        $data->tanggal_formatted = Carbon::parse($data->tanggal)->translatedFormat('d F Y');




        $kasi = User::where('role', 'kasi')->first();
        $kabid = User::where('role', 'kabid')->first();

        $logoPath = public_path('images/logo.png');
        $type = pathinfo($logoPath, PATHINFO_EXTENSION);
        $dataLogo = file_get_contents($logoPath);
        $base64Logo = 'data:image/' . $type . ';base64,' . base64_encode($dataLogo);


        $beritaAcara = BeritaAcara::find($id);
        $base64Ttd = null;
        if ($beritaAcara && !empty($beritaAcara->Signature_WP)) {
            $ttdPath = public_path('storage/' . $beritaAcara->Signature_WP);
            // dd($ttdPath);
            if (file_exists($ttdPath)) {
                $typeTtd = pathinfo($ttdPath, PATHINFO_EXTENSION);

                $dataTtd = file_get_contents($ttdPath);
                //  dd($dataTtd);
                $base64Ttd = 'data:image/' . $typeTtd . ';base64,' . base64_encode($dataTtd);
            }
        } else {
            dd($beritaAcara);
        }
        //  dd($base64Ttd);
        // TTD Kasi jika validasi
        $base64TtdKasi = null;
        if ($beritaAcara->Validasi_Kasi == 'validasi') {
            $ttdKasiPath = public_path('images/ttdkasi.png');
            if (file_exists($ttdKasiPath)) {
                $typeTtdKasi = pathinfo($ttdKasiPath, PATHINFO_EXTENSION);
                $dataTtdKasi = file_get_contents($ttdKasiPath);
                $base64TtdKasi = 'data:image/' . $typeTtdKasi . ';base64,' . base64_encode($dataTtdKasi);
            }
        }

        // TTD Kabid jika validasi
        $base64TtdKabid = null;
        if ($beritaAcara->Validasi_Kabid == 'validasi') {
            $ttdKabidPath = public_path('images/ttdkabid.png');
            if (file_exists($ttdKabidPath)) {
                $typeTtdKabid = pathinfo($ttdKabidPath, PATHINFO_EXTENSION);
                $dataTtdKabid = file_get_contents($ttdKabidPath);
                $base64TtdKabid = 'data:image/' . $typeTtdKabid . ';base64,' . base64_encode($dataTtdKabid);
            }
        }


        $pdf = Pdf::loadView('berita-acara.pdf', [
            'data' => $data,
            'kasi' => $kasi,
            'kabid' => $kabid,
            'base64Logo' => $base64Logo,
            'base64Ttd' => $base64Ttd,
            'base64TtdKasi' => $base64TtdKasi,
            'base64TtdKabid' => $base64TtdKabid,
        ]);

        // Stream PDF ke browser
        return $pdf->stream('berita-acara.pdf');
    }

    public function validasiKasi($id)
    {
        $berita = BeritaAcara::findOrFail($id);

        // Hanya role kasi yang boleh validasi
        if (Auth::user()->role != 'kasi') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses validasi.');
        }

        // Update status validasi kasi
        $berita->Validasi_Kasi = 'validasi';
        $berita->save();

        return redirect()->back()->with('success', 'Validasi oleh Kasi berhasil.');
    }

    public function validasiKabid($id)
    {
        $berita = BeritaAcara::findOrFail($id);

        if (Auth::user()->role != 'kabid') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses validasi.');
        }

        $berita->Validasi_Kabid = 'validasi';
        $berita->save();

        return redirect()->back()->with('success', 'Validasi oleh Kabid berhasil.');
    }

    public function uploadSignature(Request $request)
    {
        $base64 = $request->input('base64'); // base64 dari canvas

        $image = base64_decode(explode(',', $base64)[1]);
        $filename = uniqid() . '_signature.png';
        $path = storage_path('app/public/ttd_wp/' . $filename);
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }
        file_put_contents($path, $image);

        return response()->json([
            'path' => 'ttd_wp/' . $filename
        ]);
    }

    public function delete($id)
    {
        // Cari berdasarkan id
        $beritaAcara = BeritaAcara::findOrFail($id);

        // Hapus data
        $beritaAcara->delete();

        // Redirect kembali ke indeks dengan pesan sukses
        return redirect()->route('berita-acara.index')->with('success', 'Data Berita Acara berhasil dihapus');
    }
}
