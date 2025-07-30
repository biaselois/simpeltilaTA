<form action="{{ route('signature.update', $signature->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="hidden" name="user_id" value="{{ $signature->user_id }}">
    <p>Nama: {{ $signature->user->name }}</p>

    <div class="form-group">
        <label>NIP</label>
        <input type="text" name="nip" class="form-control" value="{{ $signature->nip }}">
    </div>

    <div class="form-group">
        <label>NIK</label>
        <input type="text" name="nik" class="form-control" value="{{ $signature->nik }}">
    </div>

    <div class="form-group">
        <label>QR Code (opsional)</label><br>
        <img src="{{ asset('storage/' . $signature->qrcode) }}" height="100"><br>
        <input type="file" name="qrcode" class="form-control">
    </div>

    <div class="form-group">
        <label>TTD (opsional)</label><br>
        <img src="{{ asset('storage/' . $signature->ttd) }}" height="100"><br>
        <input type="file" name="ttd" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
