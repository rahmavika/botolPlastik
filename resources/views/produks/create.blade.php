@extends('layouts.main')

@section('content')
<div class="container mt-4">

    {{-- TITLE --}}
    <div class="mb-4">
        <h4 class="mb-1">Input Data Produk</h4>
        <small class="text-muted">Form penambahan produk baru</small>
        <hr>
    </div>

    <div class="row">
        <div class="col-md-8">

            <div class="card border">
                <div class="card-body">

                    <form action="/dashboard-produk" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Produk --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text"
                                   class="form-control @error('nama_produk') is-invalid @enderror"
                                   name="nama_produk"
                                   value="{{ old('nama_produk') }}">
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number"
                                   step="0.01"
                                   class="form-control @error('harga') is-invalid @enderror"
                                   name="harga"
                                   value="{{ old('harga') }}">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gambar --}}
                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file"
                                   class="form-control @error('gambar') is-invalid @enderror"
                                   name="gambar">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text"
                                   class="form-control @error('keterangan') is-invalid @enderror"
                                   name="keterangan"
                                   value="{{ old('keterangan') }}">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BUTTON --}}
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection