@extends('layouts.main')
@section('content')

<div class="container mt-4">
    <div class="mb-4">
        <h4 class="mb-1">Edit Data Produk</h4>
        <small class="text-muted">Perbarui informasi produk</small>
        <hr>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card border">
                <div class="card-body">
                    <form action="/dashboard-produk/{{ $produk->id }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text"class="form-control @error('nama_produk') is-invalid @enderror"name="nama_produk"value="{{ old('nama_produk', $produk->nama_produk) }}">
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number"step="0.01"class="form-control @error('harga') is-invalid @enderror"name="harga"value="{{ old('harga', $produk->harga) }}">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file"class="form-control @error('gambar') is-invalid @enderror"name="gambar">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text"class="form-control @error('keterangan') is-invalid @enderror"name="keterangan"value="{{ old('keterangan', $produk->keterangan) }}">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn" style="background: linear-gradient(90deg, #3557c7, #4f7df0); color: white; border: none;">
                            Update
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection