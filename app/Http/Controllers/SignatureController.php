<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignatureController extends Controller
{
    public function index()
    {
        $signatures = Signature::with('user')->get();
        $users = User::whereIn('role', ['kasi', 'kabid'])->get();
        return view('signature.index', compact('signatures', 'users'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|string',
            'nik' => 'required|string',
            'qrcode' => 'required|image|mimes:png,jpg,jpeg',
            'ttd' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        $qrcodePath = $request->file('qrcode')->store('qrcodes', 'public');
        $ttdPath = $request->file('ttd')->store('ttds', 'public');

        Signature::create([
            'user_id' => $request->user_id,
            'nip' => $request->nip,
            'nik' => $request->nik,
            'qrcode' => $qrcodePath,
            'ttd' => $ttdPath,
        ]);

        return redirect()->route('signature.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $signature = Signature::findOrFail($id);
        $users = User::all();
        return view('signature.edit', compact('signature', 'users'));
    }

    public function update(Request $request, $id)
    {
        $signature = Signature::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|string',
            'nik' => 'required|string',
            'qrcode' => 'image|mimes:png,jpg,jpeg',
            'ttd' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($request->hasFile('qrcode')) {
            Storage::disk('public')->delete($signature->qrcode);
            $signature->qrcode = $request->file('qrcode')->store('qrcodes', 'public');
        }

        if ($request->hasFile('ttd')) {
            Storage::disk('public')->delete($signature->ttd);
            $signature->ttd = $request->file('ttd')->store('ttds', 'public');
        }

        $signature->update([
            'user_id' => $request->user_id,
            'nip' => $request->nip,
            'nik' => $request->nik,
            'qrcode' => $signature->qrcode,
            'ttd' => $signature->ttd,
        ]);

        return redirect()->route('signature.index')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $signature = Signature::findOrFail($id);
        Storage::disk('public')->delete([$signature->qrcode, $signature->ttd]);
        $signature->delete();
        return redirect()->route('signature.index')->with('success', 'Data berhasil dihapus');
    }
}
