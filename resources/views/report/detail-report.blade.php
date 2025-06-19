@extends('layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">Detail Jadwal Tinjauan Selesai oleh {{ $user->name }}</h1>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <a href="{{ route('report.petugas') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Jadwal Tinjau Selesai</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Permohonan</th>
                                    <th>Nama WP</th>
                                    <th>Lokasi</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal Tinjau</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwals as $index => $jadwal)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if ($jadwal->permohonan)
                                                {{ $jadwal->permohonan->nomordokumen }} /
                                                {{ $jadwal->permohonan->nama_wp }} /
                                                {{ $jadwal->permohonan->tujuan }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $jadwal->permohonan->nama_wp ?? '-' }}</td>
                                        <td>{{ $jadwal->permohonan->alamat_objek ?? '-' }}</td>
                                        <td>{{ $jadwal->permohonan->tujuan ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_tinjau)->format('d-m-Y') }}</td>
                                        <td><span class="badge badge-success">Selesai</span></td>
                                    </tr>
                                @endforeach

                                @if ($jadwals->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada jadwal yang diselesaikan.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
