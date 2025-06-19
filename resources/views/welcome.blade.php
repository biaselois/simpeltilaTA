
            @extends('layout.guest')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Jadwal Tinjau Lapang</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jadwal as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($item->permohonan)
                                                        {{ $item->permohonan->nomordokumen }} /
                                                        {{ $item->permohonan->nama_wp }} /
                                                        {{ $item->permohonan->tujuan }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (optional($item->permohonan)->dokumen)
                                                        <a href="{{ asset('dokumen/' . optional($item->permohonan)->dokumen) }}"
                                                            target="_blank">Lihat Dokumen</a>
                                                    @else
                                                        Tidak ada dokumen
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_tinjau)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $item->permohonan->alamat_objek }}</td>

                                                <td>
                                                    @if ($item->petugas->count())
                                                        <ul class="mb-0 pl-3">
                                                            @foreach ($item->petugas as $petugas)
                                                                <li>{{ $item->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($item->status == 'Selesai')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @elseif ($item->status == 'Menunggu')
                                                        <span class="badge badge-warning">Menunggu</span>
                                                    @else
                                                        <span
                                                            class="badge badge-danger">{{ ucfirst($item->status) }}</span>
                                                    @endif
                                                </td>



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


