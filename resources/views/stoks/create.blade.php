@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h3 text-center">Input Stok Produk</h2>
</div>

<div class="row">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card shadow-sm">
      <div class="card-body">
        <form action="/dashboard-stok" method="post" enctype="multipart/form-data">
          @csrf
            <div class="mb-3">
                <label for="produk_id" class="form-label">Produk</label>
                <select class="form-select" name="produk_id" id="produk_id">
                    <option value="">--Pilih Produk--</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                    @endforeach
                </select>
                @error('produk_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
                <input type="number" step="0.01" class="form-control @error('harga') is-invalid @enderror"
                name="jumlah_stok" id="jumlah_stok" value="{{ old('jumlah_stok') }}" placeholder="Jumlah Stok Produk" required>
                @error('jumlah_stok')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            </div>
          <button type="submit" class="btn btn-success w-100">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
