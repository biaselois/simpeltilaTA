@extends('layout.main')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Berita Acara</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Berita Acara</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan pada inputan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('berita-acara.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Form Edit Berita Acara</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Jadwal</label>
                                    <select name="jadwal_id" class="form-control">
                                        @foreach ($jadwals as $jadwal)
                                        <option value="{{ $jadwal->id }}"
                                            {{ $jadwal->id == $berita->jadwal_id ? 'selected' : '' }}>
                                            {{ $jadwal->id }} - {{ $jadwal->lokasi }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('jadwal_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control"
                                        value="{{ $berita->tanggal }}">
                                    @error('tanggal')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Hasil</label>
                                    <textarea name="Hasil" class="form-control" rows="2">{{ $berita->Hasil }}</textarea>
                                    @error('Hasil')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Rekomendasi</label>
                                    <textarea name="Rekomendasi" class="form-control" rows="2">{{ $berita->Rekomendasi }}</textarea>
                                    @error('Rekomendasi')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Upload Dokumentasi (jpg, png, pdf)</label>
                                    <input type="file" name="dokumentasi" class="form-control"
                                        accept=".jpg,.png,.pdf">
                                    @if ($berita->dokumentasi)
                                    <p class="mt-2">File saat ini:
                                        <a href="{{ asset('storage/' . $berita->dokumentasi) }}" target="_blank">Lihat
                                            Dokumentasi</a>
                                    </p>
                                    @endif
                                    @error('dokumentasi')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Upload Tanda Tangan WP (png, jpg)</label>
                                    <input type="file" name="Signature_WP" class="form-control" accept=".png,.jpg">
                                    @if ($berita->Signature_WP)
                                    <p class="mt-2">File saat ini:
                                        <img src="{{ asset('storage/' . $berita->Signature_WP) }}" alt="Tanda Tangan WP"
                                            height="50">
                                    </p>
                                    @endif
                                    @error('Signature_WP')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Berita Acara</button>
                                <a href="{{ route('berita-acara.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
