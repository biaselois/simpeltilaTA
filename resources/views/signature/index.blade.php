@extends('layout.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Signature</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Signature</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Signature</h1>
        </div>
    </div> --}}

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- Form Tambah/Edit -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title text-white">Form Tambah/Edit Tanda Tangan</h3>
                        </div>
                        <div class="card-body">
                            <form id="signatureForm" method="POST" enctype="multipart/form-data" action="{{ route('signature.store') }}">
                                @csrf
                                <input type="hidden" name="_method" id="formMethod" value="POST">
                                <input type="hidden" name="id" id="signatureId">

                                <div class="form-group">
                                    <label for="user_id">User</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">-- Pilih User --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="text" name="nip" id="nip" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" name="nik" id="nik" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="qrcode">QR Code</label>
                                    <input type="file" name="qrcode" class="form-control-file" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <label for="ttd">TTD</label>
                                    <input type="file" name="ttd" class="form-control-file" accept="image/*">
                                </div>

                                <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                                <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Daftar -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title text-white">Daftar Tanda Tangan</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>NIK</th>
                                        <th>QR Code</th>
                                        <th>TTD</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($signatures as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->user->name ?? '-' }}</td>
                                        <td>{{ $d->nip }}</td>
                                        <td>{{ $d->nik }}</td>
                                        <td>
                                            @if ($d->qrcode)
                                                <img src="{{ asset('storage/' . $d->qrcode) }}" width="50">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($d->ttd)
                                                <img src="{{ asset('storage/' . $d->ttd) }}" width="50">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)"
                                               class="btn btn-primary btn-edit"
                                               data-id="{{ $d->id }}"
                                               data-user_id="{{ $d->user_id }}"
                                               data-nip="{{ $d->nip }}"
                                               data-nik="{{ $d->nik }}">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <a data-toggle="modal" data-target="#modal-hapus{{ $d->id }}" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="modal-hapus{{ $d->id }}">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <p>Apakah Kamu Yakin Ingin Menghapus Data User <b>{{ $d->user->name ?? '-' }}</b>?</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <form action="{{ route('signature.delete',['id' => $d->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Ya, Hapus Data</button>
                                                </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    @endforeach

                                    @if ($signatures->count() == 0)
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Belum ada data tanda tangan.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div> <!-- /.row -->
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    // Tambahan base URL update
    const updateUrl = "{{ url('/signature/update') }}";

    // Tombol edit
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const user_id = this.dataset.user_id;
            const nip = this.dataset.nip;
            const nik = this.dataset.nik;

            // Set value ke form
            document.getElementById('signatureId').value = id;
            document.getElementById('user_id').value = user_id;
            document.getElementById('nip').value = nip;
            document.getElementById('nik').value = nik;

            // Set form action ke update URL
            const form = document.getElementById('signatureForm');
            form.action = `${updateUrl}/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('submitBtn').textContent = 'Update';
        });
    });

    // Tombol reset
    document.getElementById('resetBtn').addEventListener('click', function () {
        const form = document.getElementById('signatureForm');
        form.reset();
        form.action = "{{ route('signature.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('submitBtn').textContent = 'Simpan';
        document.getElementById('signatureId').value = '';
    });
</script>
@endsection

