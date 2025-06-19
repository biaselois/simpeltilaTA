@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Berita Acara</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tambah Berita Acara</li>
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

                <form action="{{ route('berita-acara.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Tambah Berita Acara</h3>
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <input type="hidden" name="jadwal_id"
                                            value="{{ old('jadwal_id', $selectedJadwalId ?? '') }}">
                                        <select class="form-control" disabled>
                                            @foreach ($jadwals as $jadwal)
                                                <option value="{{ $jadwal->id }}"
                                                    {{ old('jadwal_id', $selectedJadwalId ?? '') == $jadwal->id ? 'selected' : '' }}>
                                                    {{ $jadwal->permohonan->nomordokumen ?? '-' }} /
                                                    {{ $jadwal->permohonan->nama_wp ?? '-' }}/
                                                    {{ $jadwal->permohonan->tujuan ?? '-' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control">
                                        @error('tanggal')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group">
                                        <label>Nama WP</label>
                                        <input type="text" name="Nama_WP" class="form-control" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat WP</label>
                                        <input type="text" name="Alamat_WP" class="form-control" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>NOP</label>
                                        <input type="text" name="NOP" class="form-control" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat OP</label>
                                        <input type="text" name="Alamat_OP" class="form-control" readonly>
                                    </div>

                                   <div class="form-group">
                                        <label>Tujuan Permohonan</label>
                                        <input type="text" name="tujuan" class="form-control" readonly>
                                    </div> --}}

                                    <div class="form-group">
                                        <label>Hasil</label>
                                        <textarea name="Hasil" class="form-control" rows="2" placeholder="Masukkan Hasil"></textarea>
                                        @error('Hasil')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Rekomendasi</label>
                                        <textarea name="Rekomendasi" class="form-control" rows="2" placeholder="Masukkan Rekomendasi"></textarea>
                                        @error('Rekomendasi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Upload Dokumentasi (jpg, png, pdf)</label>
                                        <input type="file" name="dokumentasi" class="form-control"
                                            accept=".jpg,.png,.pdf">
                                        @error('dokumentasi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Tanda Tangan WP -->
                                    <div class="form-group">
                                        <label for="">Tanda Tangan WP</label>
                                        <br>
                                        <canvas id="signaturePad" style="border: 2px solid black; border-radius: 10px;"
                                            width="500" height="250"></canvas>
                                        <br>
                                        <button id="clearBtn" type="button"
                                            class="btn btn-danger mt-2">hapus</button>
                                        <button id="saveBtn" type="button"
                                            class="btn btn-primary mt-2 ml-2">Simpan</button>
                                        <input type="hidden" name="Signature_WP" id="signature_field">
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Berita Acara</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </section>
    </div>

@endsection
@section('scripts')
    <script>
        const canvas = document.getElementById('signaturePad');
        const context = canvas.getContext('2d');
        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;

        canvas.addEventListener('mousedown', (e) => {
            isDrawing = true;
            [lastX, lastY] = [e.offsetX, e.offsetY];
        });

        canvas.addEventListener('mousemove', (e) => {
            if (!isDrawing) return;
            context.lineWidth = 5;
            context.lineCap = 'round';

            context.beginPath();
            context.moveTo(lastX, lastY);
            context.lineTo(e.offsetX, e.offsetY);
            context.stroke();

            [lastX, lastY] = [e.offsetX, e.offsetY];
        });

        canvas.addEventListener('mouseup', () => isDrawing = false);
        canvas.addEventListener('mouseleave', () => isDrawing = false);

        document.getElementById('clearBtn').addEventListener('click', () => {
            context.clearRect(0, 0, canvas.width, canvas.height);
        });

        document.getElementById('saveBtn').addEventListener('click', () => {
            const base64 = canvas.toDataURL('image/png'); // dapat base64
            document.getElementById('signature_field').value = base64;
            alert('Tanda tangan disimpan di form');
        });
    </script>
@endsection
