@extends('layout.main')
@section('content')
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
                <form action="{{ route('permohonan.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Edit Permohonan</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nomor Dokumen</label>
                                        <input type="text" name="nomordokumen" class="form-control"
                                            value="{{ old('nomordokumen', $data->nomordokumen) }}">
                                        @error('nomordokumen')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Nama WP</label>
                                        <input type="text" name="nama_wp" class="form-control"
                                            value="{{ old('nama_wp', $data->nama_wp) }}">
                                        @error('nama_wp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat WP</label>
                                        <input type="text" name="alamat_wp" class="form-control"
                                            value="{{ old('alamat_wp', $data->nama_wp) }}">
                                        @error('alamat_wp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>NOP</label>
                                        <input type="number" name="nop" class="form-control"
                                            value="{{ old('nop', $data->nop) }}" required>
                                        @error('nop')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat OP</label>
                                        <textarea name="alamat_objek" class="form-control" rows="2">{{ old('alamat_objek', $data->alamat_objek) }}</textarea>
                                        @error('alamat_objek')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuan">Tujuan Permohonan</label>
                                        <select name="tujuan" class="form-control">
                                            <option value="">-- Pilih Tujuan Permohonan --</option>
                                            <option value="Objek Pajak Baru"
                                                {{ old('tujuan', $data->tujuan) == 'Objek Pajak Baru' ? 'selected' : '' }}>
                                                1. Objek Pajak Baru</option>
                                            <option value="Mutasi/ Balik Nama"
                                                {{ old('tujuan', $data->tujuan) == 'Mutasi/ Balik Nama' ? 'selected' : '' }}>
                                                2. Mutasi/ Balik Nama</option>
                                            <option value="Pemecahan"
                                                {{ old('tujuan', $data->tujuan) == 'Pemecahan' ? 'selected' : '' }}>3.
                                                Pemecahan</option>
                                            <option value="Penggabungan"
                                                {{ old('tujuan', $data->tujuan) == 'Penggabungan' ? 'selected' : '' }}>4.
                                                Penggabungan</option>
                                            <option value="Pembatalan/ Penghapusan"
                                                {{ old('tujuan', $data->tujuan) == 'Pembatalan/ Penghapusan' ? 'selected' : '' }}>
                                                5. Pembatalan/ Penghapusan</option>
                                            <option value="Perubahan Data"
                                                {{ old('tujuan', $data->tujuan) == 'Perubahan Data' ? 'selected' : '' }}>6.
                                                Perubahan Data</option>
                                            <option value="Keberatan/ Pengurangan"
                                                {{ old('tujuan', $data->tujuan) == 'Keberatan/ Pengurangan' ? 'selected' : '' }}>
                                                7. Keberatan/ Pengurangan</option>
                                            <option value="Penilaian Individu"
                                                {{ old('tujuan', $data->tujuan) == 'Penilaian Individu' ? 'selected' : '' }}>
                                                8. Penilaian Individu</option>
                                            <option value="Verifikasi BPHTB"
                                                {{ old('tujuan', $data->tujuan) == 'Verifikasi BPHTB' ? 'selected' : '' }}>
                                                9. Verifikasi BPHTB</option>
                                            <option value="Lainnya"
                                                {{ old('tujuan', $data->tujuan) == 'Lainnya' ? 'selected' : '' }}>10.
                                                Lainnya</option>
                                        </select>
                                        @error('tujuan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>Dokumen (PDF)</label><br>
                                        @if ($data->dokumen)
                                            <a href="{{ asset('dokumen/' . $data->dokumen) }}" target="_blank">Lihat
                                                Dokumen Saat Ini</a><br><br>
                                        @endif
                                        <input type="file" name="dokumen" class="form-control" accept="application/pdf">
                                        @error('dokumen')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">simpan</button>
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <a href="{{ route('permohonan.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
