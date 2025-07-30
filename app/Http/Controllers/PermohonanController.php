<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Imports\PermohonanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;



class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $data =permohonan::get();
        $query = Permohonan::query();

       // Filter pencarian
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nama_wp', 'like', '%' . $search . '%')
              ->orWhere('nop', 'like', '%' . $search . '%');
        });
    }

    // Filter tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    } elseif ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    } elseif ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    $data = $query->latest()->get();;
        return view('permohonan.index', compact('data'));
    }

    public function create(Request $request)
    {
    $lastNumber = Permohonan::max('id') ?? 0;
    $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // 0001, 0002, dst
    $tahun = Carbon::now()->year;
    $tujuanText ='tujuan';

    $nomorSurat = $nextNumber . '/' . $tujuanText . '/PBB-P2/BAPENDA/' . $tahun;

        return view('permohonan.create', compact('nomorSurat'));

    }

    public function store(Request $request)
    {
        $request->validate([
            // 'nomordokumen'  => 'required',
            'nama_wp'       => 'required',
            'alamat_wp'     => 'required',
            'nop'           => 'required',
            'alamat_objek'  => 'required',
            'tujuan'        => 'required',
            'tujuan_lainnya' => 'required_if:tujuan,Lainnya',
            'dokumen'       => 'required|mimes:pdf|max:2048',
        ]);
         $lastNumber = Permohonan::max('id') ?? 0;
    $nextNumber = $lastNumber + 1;
    $tahun = Carbon::now()->year;
    $tujuanText = $request->tujuan === 'Lainnya' ? $request->tujuan_lainnya : $request->tujuan;
    $nomorSurat = $nextNumber . '/' . $tujuanText . '/PBB-P2/BAPENDA/' . $tahun;


        $file = $request->file('dokumen');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/dokumen', $filename);

        $tujuan = $request->tujuan === 'Lainnya' ? $request->tujuan_lainnya : $request->tujuan;

        Permohonan::create([
            'nomordokumen'  => $nomorSurat,
            'nama_wp'       => $request->nama_wp,
            'alamat_wp'     => $request->alamat_wp,
            'nop'           => $request->nop,
            'alamat_objek'  => $request->alamat_objek,
            'tujuan'        => $tujuan,
            'dokumen'       => $filename,
        ]);

        return redirect()->route('permohonan.index')->withSuccess('Task Created Successfully!');
    }

    public function edit($id)
    {
        $data = Permohonan::findOrFail($id);
        return view('permohonan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomordokumen'  => 'required',
            'nama_wp'       => 'required',
            'alamat_wp'     => 'required',
            'nop'           => 'required',
            'alamat_objek'  => 'required',
            'tujuan'        => 'required',
            'tujuan_lainnya' => 'required_if:tujuan,Lainnya',
            'dokumen'       => 'required|mimes:pdf|max:2048',
        ]);

        $data = Permohonan::findOrFail($id);

        // Hapus file lama jika ada file baru
        if ($request->hasFile('dokumen')) {
            if ($data->dokumen && Storage::exists('public/dokumen/' . $data->dokumen)) {
                Storage::delete('public/dokumen/' . $data->dokumen);
            }

            $file = $request->file('dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/dokumen', $filename);
            $data->dokumen = $filename;
        }
        $tujuan = $request->tujuan === 'Lainnya' ? $request->tujuan_lainnya : $request->tujuan;

        $data->nomordokumen  = $request->nomordokumen;
        $data->nama_wp       = $request->nama_wp;
        $data->alamat_wp     = $request->alamat_wp;
        $data->nop           = $request->nop;
        $data->alamat_objek  = $request->alamat_objek;
        $data->tujuan        = $tujuan;
        $data->save();

        return redirect()->route('permohonan.index')->with('success', 'Task Created Successfully!');
    }

   public function delete(Request $request, $id)
{
    $data = Permohonan::findOrFail($id);

      if ($data->dokumen && Storage::exists('public/dokumen/' . $data->dokumen)) {
            Storage::delete('public/dokumen/' . $data->dokumen);
        }

    $data->delete();

    return redirect()->route('permohonan.index')->with('success', 'Data berhasil dihapus!');
}



public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xls,xlsx',
    ]);

    try {

        Excel::import(new PermohonanImport, $request->file('file'));

        return redirect()->back()->with('success', 'Import data berhasil.');

    } catch(\Illuminate\Database\QueryException $e) {

        if ($e->getCode() == 23000) {
            return redirect()->back()->with('error', 'Id tidak boleh sama (duplikat).');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import');
        }
    }
  }
}
