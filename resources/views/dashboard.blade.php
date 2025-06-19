@extends('layout.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Data User</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $jumlahPermohonan }}</h3>

                                <p>Permohonan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-email"></i>
                            </div>
                            <a href="{{ route('permohonan.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $jumlahJadwal }}<sup style="font-size: 20px"></sup></h3>

                                <p>Jadwal</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-calendar"></i>
                            </div>
                            <a href="{{ route('jadwal.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $jumlahBeritaAcara }}</h3>

                                <p>Berita Acara</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clipboard"></i>
                            </div>
                            <a href="{{ route('berita-acara.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    @if (auth()->user()->role === 'kasi')
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $jumlahUser }}</h3>

                                <p>Petugas</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('report.petugas') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row">
                </div>
                <div class="card mb-2">
                        <div class="card-header">Grafik Kegiatan Per <b>Bulan</b></div>
                        <div class="card-body">
                            <div style="width: 900px; height: 600px;">
                                <canvas id="chartKegiatan"></canvas>
                            </div>
                        </div>
                    </div>
                <div class="card mt-4">
                    <div class="card-header">
                        Jadwal Tinjau Lapang
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Permohonan</th>
                                    <th>Dokumen Pendukung</th>
                                    <th>Tanggal Tinjau</th>
                                    <th>Lokasi</th>
                                    <th>Petugas Lapang</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwalMenunggu as $index => $jadwal)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($jadwal->permohonan)
                                                {{ $jadwal->permohonan->nomordokumen }} /
                                                {{ $jadwal->permohonan->nama_wp }} /
                                                {{ $jadwal->permohonan->tujuan }}
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
                                                <span class="badge badge-danger">{{ ucfirst($jadwal->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada jadwal</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartKegiatan').getContext('2d');
        const chartKegiatan = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Tinjau Lapang',
                    data: @json($dataGrafik),
                    backgroundColor: 'rgba(0, 123, 255, 0.6)', // primary
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 50,
                        ticks: {
                            stepSize: 10,
                            preccisiom: 0
                        }
                    }
                }
            }
        });
    </script>

@endsection
