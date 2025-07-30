@extends('layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Jadwal Tinjau Lapang</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active breadcrumb-active"> Jadwal</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                        @if (auth()->user()->role == 'kasi')
                            <form action="{{ route('jadwal.index') }}" method="GET" class="form-inline">
                                <input type="date" name="start_date" class="form-control mr-2"
                                    value="{{ request('start_date') }}">
                                <input type="date" name="end_date" class="form-control mr-2"
                                    value="{{ request('end_date') }}">
                                <button type="submit" class="btn btn-success">Tampilkan</button>
                            </form>
                        @endif

                        <form action="{{ route('jadwal.index') }}" method="GET" class="form-inline ml-auto">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari Nama WP atau NOP..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="col-12">
                        {{-- @if (auth()->user()->role == 'kasi')
                            <a href="{{ route('jadwal.create') }}" class="btn btn-primary mb-3">Buat Jadwal</a>
                        @endif --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tabel Jadwal</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Permohonan</th>
                                            <th>Dokumen Pendukung</th>
                                            <th>Tanggal Tinjau</th>
                                            <th>Lokasi</th>
                                            <th>Petugas Lapang</th>
                                            <th>Status</th>
                                            @if (auth()->user()->role === 'petugas' || auth()->user()->role === 'kasi')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $jadwal)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($jadwal->permohonan)
                                                        {{ $jadwal->permohonan->nomordokumen }} /
                                                        {{ $jadwal->permohonan->nama_wp }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (optional($jadwal->permohonan)->dokumen)
                                                        <a href="{{ asset('dokumen/' . optional($jadwal->permohonan)->dokumen) }}"
                                                            target="_blank">Lihat Dokumen</a>
                                                    @else
                                                        Tidak ada dokumen
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_tinjau)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $jadwal->permohonan->alamat_objek }}</td>

                                                <td>
                                                    @if ($jadwal->petugas->count())
                                                        <ul class="mb-0 pl-3">
                                                            @foreach ($jadwal->petugas as $petugas)
                                                                <li>{{ $petugas->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($jadwal->status == 'Selesai')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @elseif ($jadwal->status == 'Menunggu')
                                                        <span class="badge badge-warning">Menunggu</span>
                                                    @else
                                                        <span
                                                            class="badge badge-danger">{{ ucfirst($jadwal->status) }}</span>
                                                    @endif
                                                </td>
                                                @if (auth()->user()->role === 'petugas' && !$jadwal->beritaAcara)
                                                    <td>
                                                        <a href="{{ route('berita-acara.create', ['jadwal_id' => $jadwal->id]) }}"
                                                            class="btn btn-primary">
                                                            <i class="fas fa-file-alt mr-1"></i>
                                                        </a>
                                                    </td>
                                                @endif

                                                @if (auth()->user()->role == 'kasi')
                                                    <td>
                                                        <a href="{{ route('jadwal.edit', $jadwal->id) }}"
                                                            class="btn btn-primary"><i class="fas fa-pen"></i></a>
                                                        <form action="{{ route('jadwal.destroy', $jadwal->id) }}"
                                                            method="POST" style="display:inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                onclick="return confirm('Hapus jadwal ini?')"
                                                                class="btn btn-danger"><i
                                                                    class="fas fa-trash-alt"></i></button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
