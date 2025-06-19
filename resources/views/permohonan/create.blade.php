@extends('layout.main')
@section('content')
@include('sweetalert::alert')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Permohonan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tambah Permohonan</li>
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
                <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Tambah Permohonan</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nomor Dokumen</label>
                                        <input type="text" name="nomordokumen" class="form-control"
                                            placeholder="Masukkan Nomor Dokumen">
                                        @error('nomordokumen')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Nama WP</label>
                                        <input type="text" name="nama_wp" class="form-control"
                                            placeholder="Masukkan Nama WP">
                                        @error('nama_wp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat WP</label>
                                        <textarea name="alamat_wp" class="form-control" rows="2" placeholder="Masukkan Alamat WP"></textarea>
                                        @error('alamat_wp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>NOP</label>
                                        <input type="number" name="nop" class="form-control"
                                            placeholder="Masukkan NOP">
                                        @error('nop')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat OP</label>
                                        <textarea name="alamat_objek" class="form-control" rows="2" placeholder="Masukkan Alamat OP"></textarea>
                                        @error('alamat_objek')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuan">Tujuan Permohonan</label>
                                        <select name="tujuan" class="form-control">
                                            <option value="">-- Pilih Tujuan Permohonan --</option>
                                            <option value="Objek Pajak Baru"> Objek Pajak Baru</option>
                                            <option value="Mutasi/ Balik Nama"> Mutasi/ Balik Nama</option>
                                            <option value="Pemecahan"> Pemecahan</option>
                                            <option value="Penggabungan"> Penggabungan</option>
                                            <option value="Pembatalan/ Penghapusan"> Pembatalan/ Penghapusan</option>
                                            <option value="Perubahan Data"> Perubahan Data</option>
                                            <option value="Keberatan/ Pengurangan"> Keberatan/ Pengurangan</option>
                                            <option value="Penilaian Individu"> Penilaian Individu</option>
                                            <option value="Verifikasi BPHTB"> Verifikasi BPHTB</option>
                                            <option value="Lainnya"> Lainnya</option>
                                        </select>
                                        @error('tujuan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>Upload Dokumen (PDF)</label>
                                        <input type="file" name="dokumen" class="form-control" accept="application/pdf">
                                        @error('dokumen')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Kirim Permohonan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
