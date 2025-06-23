@extends('layout.main')


@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Berita Acara</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Berita Acara</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                        <form action="{{ route('berita-acara.index') }}" method="GET" class="form-inline">
                            <input type="date" name="start_date" class="form-control mr-2"
                                value="{{ request('start_date') }}">
                            <input type="date" name="end_date" class="form-control mr-2"
                                value="{{ request('end_date') }}">
                            <button type="submit" class="btn btn-success">Tampilkan</button>
                        </form>

                        <form action="{{ route('berita-acara.index') }}" method="GET" class="form-inline">
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
                        {{-- @if (auth()->user()->role == 'petugas')
                            <a href="{{ route('berita-acara.create') }}" class="btn btn-primary mb-3">Tambah Berita
                                Acara</a>
                        @endif --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tabel Berita Acara</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table id="beritaAcaraTable" class="table table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Permohonan</th>
                                            <th>Petugas</th>
                                            <th>Tanggal</th>
                                            <th>Nama WP</th>
                                            <th>Alamat WP</th>
                                            <th>NOP</th>
                                            <th>Alamat OP</th>
                                            {{-- <th>Tujuan</th>
                          <th>Hasil</th>
                          <th>Rekomendasi</th>
                          <th>Dokumentasi</th>
                          <th>Signature WP</th> --}}
                                            <th>Validasi Kasi</th>
                                            <th>Validasi Kabid</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $d)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $d->jadwal->permohonan->nomordokumen ?? '-' }} /
                                                    {{ $d->jadwal->permohonan->nama_wp ?? '-' }} /
                                                    {{ $d->jadwal->permohonan->tujuan ?? '-' }}
                                                </td>
                                                <td>
                                                    @if ($d->jadwal && $d->jadwal->petugas->count())
                                                        <ul class="mb-0 pl-3">
                                                            @foreach ($d->jadwal->petugas as $petugas)
                                                                <li>{{ $petugas->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ $d->tanggal }}</td>
                                                <td>{{ $d->Nama_WP }}</td>
                                                <td>{{ $d->Alamat_WP }}</td>
                                                <td>{{ $d->NOP }}</td>
                                                <td>{{ $d->Alamat_OP }}</td>
                                                {{-- <td>{{ $d->Tujuan }}</td>
                          <td>{{ $d->Hasil }}</td>
                          <td>{{ $d->Rekomendasi }}</td>
                          <td>
                            @if ($d->dokumentasi)
                              <a href="{{ asset('storage/' . $d->dokumentasi) }}" target="_blank">
                                <img src="{{ asset('storage/' . $d->dokumentasi) }}" width="50" class="img-thumbnail">
                              </a>
                            @endif
                          </td>
                          <td>
                            @if ($d->Signature_WP)
                              <a href="{{ asset('storage/' . $d->Signature_WP) }}" target="_blank">
                                <img src="{{ asset('storage/' . $d->Signature_WP) }}" width="50" class="img-thumbnail">
                              </a>
                            @endif
                          </td> --}}
                                                <td>
                                                    @if ($d->Validasi_Kasi == 'validasi')
                                                        <span class="badge badge-success">validasi</span>
                                                    @elseif ($d->Validasi_Kasi == 'menunggu')
                                                        <span class="badge badge-warning">menunggu</span>
                                                    @else
                                                        <span
                                                            class="badge badge-danger">{{ ucfirst($d->Validasi_Kasi) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($d->Validasi_Kabid == 'validasi')
                                                        <span class="badge badge-success">validasi</span>
                                                    @elseif ($d->Validasi_Kabid == 'menunggu')
                                                        <span class="badge badge-warning">menunggu</span>
                                                    @else
                                                        <span
                                                            class="badge badge-danger">{{ ucfirst($d->Validasi_Kabid) }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-nowrap">
                                                    <a href="{{ route('berita-acara.show', ['id' => $d->id]) }}"
                                                        class="btn btn-sm btn-info" title="Detail"><i
                                                            class="fas fa-eye"></i></a>
                                                    @if (auth()->user()->role == 'petugas')
                                                        <a href="{{ route('berita-acara.edit', ['id' => $d->id]) }}"
                                                            class="btn btn-sm btn-primary" title="Edit"><i
                                                                class="fas fa-pen"></i></a>
                                                        <a href="{{ route('berita-acara.cetak', ['id' => $d->id]) }}"
                                                            class="btn btn-sm btn-success" target="_blank" title="Cetak"><i
                                                                class="fas fa-print"></i></a>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#modal-hapus{{ $d->id }}" title="Hapus"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    @endif
                                                    @if (auth()->user()->role == 'kasi' && $d->Validasi_Kasi != 'validasi')
                                                        <button type="submit" class="btn btn-sm btn-primary"
                                                            data-toggle="modal"
                                                            data-target="#modal-validasi-kasi{{ $d->id }}">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif
                                                    @if (auth()->user()->role == 'kabid' && $d->Validasi_Kabid != 'validasi')
                                                        <button type="submit" class="btn btn-sm btn-primary"
                                                            data-toggle="modal"
                                                            data-target="#modal-validasi-kabid{{ $d->id }}">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>

                                            {{-- alert validasi kasi --}}
                                            <div class="modal fade" id="modal-validasi-kasi{{ $d->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Konfirmasi Validasi Berita Acara</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin memvalidasi berita acara ini?</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <form
                                                                action="{{ route('berita-acara.validasi.kasi', $d->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">
                                                                    Batal
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    Ya, Validasi
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- alert validasi kabid --}}
                                            <div class="modal fade" id="modal-validasi-kabid{{ $d->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Konfirmasi Validasi Berita Acara</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin memvalidasi berita acara ini?</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <form
                                                                action="{{ route('berita-acara.validasi.kabid', $d->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">
                                                                    Batal
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    Ya, Validasi
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="modal-hapus{{ $d->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah kamu yakin ingin menghapus data Berita Acara?</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <form
                                                                action="{{ route('berita-acara.delete', ['id' => $d->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">
                                                                    Batal
                                                                </button>
                                                                <button type="submit" class="btn btn-danger">
                                                                    Ya, Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

@section('scripts')
    <!-- jQuery dan DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    {{-- <script>
        $(document).ready(function() {
            $('#beritaAcaraTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    },
                }
            });
        });
    </script> --}}
@endsection
