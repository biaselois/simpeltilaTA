@extends('layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Permohonan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Permohonan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if (auth()->user()->role === 'pelayanan')
                            <a href="{{ route('permohonan.create') }}" class="btn btn-primary mb-3">Tambah Permohonan</a>
                            <button class="btn btn-success mb-3 ml-2" data-toggle="modal" data-target="#importModal">
                                Import Excel
                            </button>
                        @endif
                        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                            <form action="{{ route('permohonan.index') }}" method="GET" class="form-inline">
                                <input type="date" name="start_date" class="form-control mr-2"
                                    value="{{ request('start_date') }}">
                                <input type="date" name="end_date" class="form-control mr-2"
                                    value="{{ request('end_date') }}">
                                <button type="submit" class="btn btn-success">Tampilkan</button>
                            </form>

                            <form action="{{ route('permohonan.index') }}" method="GET" class="form-inline">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari Nama WP atau NOP..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tabel Permohonan</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor Dokumen</th>
                                            <th>Nama WP</th>
                                            <th>Alamat WP</th>
                                            <th>NOP</th>
                                            <th>Alamat OP</th>
                                            <th>Tujuan</th>
                                            <th>Dokumen Pendukung</th>
                                            <th>Status</th>

                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $d)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $d->nomordokumen }}</td>
                                                <td>{{ $d->nama_wp }}</td>
                                                <td>{{ $d->alamat_wp }}</td>
                                                <td>{{ $d->nop }}</td>
                                                <td>{{ $d->alamat_objek }}</td>
                                                <td>{{ $d->tujuan }}</td>
                                                <td>
                                                    @if (Str::startsWith($d->dokumen, ['http://', 'https://']))
                                                        <a href="{{ $d->dokumen }}" target="_blank">Lihat Dokumen</a>
                                                    @else
                                                        <a href="{{ asset('dokumen/' . $d->dokumen) }}"
                                                            target="_blank">Lihat Dokumen</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($d->status == 'Dijadwalkan')
                                                        <span class="badge badge-success">Dijadwalkan</span>
                                                    @elseif ($d->status == 'Menunggu')
                                                        <span class="badge badge-warning">Menunggu</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ ucfirst($d->status) }}</span>
                                                    @endif
                                                </td>
                                                @if (auth()->user()->role === 'kasi' && !$d->jadwal)
                                                    <td>
                                                        <a href="{{ route('jadwal.create', ['permohonan_id' => $d->id]) }}"
                                                            class="btn btn-primary" data-toggle="tooltip"
                                                            data-placement="top" title="Buat Jadwal">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </a>

                                                    </td>
                                                @endif
                                                @if (auth()->user()->role === 'pelayanan')
                                                    <td>
                                                        <a href="{{ route('permohonan.edit', ['id' => $d->id]) }}"
                                                            class="btn btn-primary"><i class="fas fa-pen"></i></a>
                                                        <a data-toggle="modal"
                                                            data-target="#modal-hapus{{ $d->id }}"
                                                            class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                @endif
                                            </tr>
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
                                                            <p>Apakah Kamu Yakin Ingin Menghapus Data Permohonan?
                                                                <b>{{ $d->nama_wp }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <form
                                                                action="{{ route('permohonan.delete', ['id' => $d->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-defailt"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Ya, Hapus
                                                                    Data</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
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
    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('permohonan.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Permohonan dari Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        {{-- Letakkan di sini, sebelum form field --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="file">Pilih File Excel</label>
                            <input type="file" name="file" class="form-control" required accept=".xls,.xlsx">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
