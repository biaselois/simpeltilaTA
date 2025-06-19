@extends('layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="mb-3">Detail Berita Acara</h1>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('berita-acara.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i>
                    </a>

                    <div>
                        @if (auth()->user()->role == 'kasi' && $data->Validasi_Kasi != 'sudah')
                            <form action="{{ route('berita-acara.validasi.kasi', $data->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary">
                                    Validasi
                                </button>
                            </form>
                        @endif

                        @if (auth()->user()->role == 'kabid' && $data->Validasi_Kabid != 'sudah' && $data->Validasi_Kasi == 'sudah')
                            <form action="{{ route('berita-acara.validasi.kabid', $data->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">
                                    Validasi
                                </button>
                            </form>
                        @endif

                        @if (auth()->user()->role == 'petugas')
                            <a href="{{ route('berita-acara.cetak', ['id' => $data->id]) }}" target="_blank"
                                class="btn btn-success ml-2">
                                <i class="fas fa-print"></i> Cetak Berita Acara
                            </a>
                        @endif
                    </div>
                </div>


                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 25%;">Jadwal</th>
                                    <td>{{ $data->jadwal_id }} - {{ $data->jadwal->lokasi }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $data->tanggal }}</td>
                                </tr>
                                <tr>
                                    <th>Petugas</th>
                                    <td>
                                        @if ($data->jadwal->petugas && $data->jadwal->petugas->count() > 0)
                                            <ul class="mb-0 pl-3">
                                                @foreach ($data->jadwal->petugas as $petugas)
                                                    <li>{{ $petugas->name }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">Tidak ada petugas</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Nama Wajib Pajak</th>
                                    <td>{{ $data->Nama_WP }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat WP</th>
                                    <td>{{ $data->Alamat_WP }}</td>
                                </tr>
                                <tr>
                                    <th>NOP</th>
                                    <td>{{ $data->NOP }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat OP</th>
                                    <td>{{ $data->Alamat_OP }}</td>
                                </tr>
                                <tr>
                                    <th>Tujuan Penelitian</th>
                                    <td>{{ $data->Tujuan }}</td>
                                </tr>
                                <tr>
                                    <th>Hasil Penelitian</th>
                                    <td>{{ $data->Hasil }}</td>
                                </tr>
                                <tr>
                                    <th>Rekomendasi</th>
                                    <td>{{ $data->Rekomendasi }}</td>
                                </tr>
                                <tr>
                                    <th>Dokumentasi</th>
                                    <td>
                                        @if ($data->dokumentasi)
                                            <a href="{{ asset('storage/' . $data->dokumentasi) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $data->dokumentasi) }}" width="100"
                                                    class="img-thumbnail">
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>TTD Wajib Pajak</th>
                                    <td>
                                        @if ($data->Signature_WP)
                                            <a href="{{ asset('storage/' . $data->Signature_WP) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $data->Signature_WP) }}" width="100"
                                                    class="img-thumbnail">
                                            </a>
                                        @else
                                            <span class="text-muted">Belum tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Validasi Kasi</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ $data->Validasi_Kasi == 'validasi' ? 'success' : ($data->Validasi_Kasi == 'menunggu' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($data->Validasi_Kasi) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Validasi Kabid</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ $data->Validasi_Kabid == 'validasi' ? 'success' : ($data->Validasi_Kabid == 'menunggu' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($data->Validasi_Kabid) }}
                                        </span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
