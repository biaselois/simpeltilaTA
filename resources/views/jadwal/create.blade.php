@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Jadwal</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Buat Jadwal</li>
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
                <form action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Tambah Jadwal</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="permohonan_id">Permohonan</label>

                                        <!-- Hidden input agar permohonan_id tetap dikirim -->
                                        <input type="hidden" name="permohonan_id"
                                            value="{{ old('permohonan_id', $selectedPermohonanId ?? '') }}">

                                        <select name="permohonan_id" id="permohonan_id"
                                            class="form-control @error('permohonan_id') is-invalid @enderror" disabled>
                                            <option value="">Pilih Permohonan</option>
                                            @foreach ($permohonans as $permohonan)
                                                <option value="{{ $permohonan->id }}"
                                                    {{ old('permohonan_id', $selectedPermohonanId ?? '') == $permohonan->id ? 'selected' : '' }}>
                                                    {{ $permohonan->nomordokumen }} / {{ $permohonan->nama_wp }} /
                                                    {{ $permohonan->tujuan }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('permohonan_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_tinjau">Tanggal Tinjau</label>
                                        <input type="date" name="tanggal_tinjau" id="tanggal_tinjau"
                                            class="form-control @error('tanggal_tinjau') is-invalid @enderror"
                                            value="{{ old('tanggal_tinjau') }}" required>
                                        @error('tanggal_tinjau')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" required>
                                    @error('lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                    <div class="form-group">
                                        <label for="petugas_id">Petugas</label>
                                        <select name="petugas_id[]" id="petugas_id"
                                            class="form-control select2 @error('petugas_id') is-invalid @enderror" multiple
                                            required>
                                            @foreach ($petugas as $petugasItem)
                                                <option value="{{ $petugasItem->id }}"
                                                    {{ collect(old('petugas_id'))->contains($petugasItem->id) ? 'selected' : '' }}>
                                                    {{ $petugasItem->name }} - {{ $petugasItem->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('petugas_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @error('petugas_id.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection


@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <!-- jQuery dan Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#petugas_id').select2({
                placeholder: "Pilih petugas",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
