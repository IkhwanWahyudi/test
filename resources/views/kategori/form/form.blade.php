<form method="POST">
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @csrf
    <div class="form-group">
        <label>Kode Kategori</label>
        <input type="text" class="form-control" name="kode" required value="{{ $data->kode ?? '' }}">
    </div>

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{ $data->nama ?? '' }}">
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>
