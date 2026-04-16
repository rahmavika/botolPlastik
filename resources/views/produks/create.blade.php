@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h3 text-center">Input Data Produk</h2>
</div>

<div class="row">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card shadow-sm">
      <div class="card-body">
        <form action="/dashboard-produk" method="post" enctype="multipart/form-data">
          @csrf
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                name="nama_produk" id="nama_produk" value="{{ old('nama_produk') }}" placeholder="Nama Produk">
                @error('nama_produk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" step="0.01" class="form-control @error('harga') is-invalid @enderror"
                name="harga" id="harga" value="{{ old('harga') }}" placeholder="Harga">
                @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                name="gambar" id="gambar">
                @error('gambar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                name="keterangan" id="keterangan" value="{{ old('keterangan') }}" placeholder="Keterangan">
                @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
          <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
