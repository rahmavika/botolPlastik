@extends('layouts.main')

@section('title', 'Detail Pertanyaan')
@section('navContactUs', 'active')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h4 class="text-dark fw-bold mb-0">Detail Pertanyaan Pengguna</h4>
    </div>

    <div class="card-body bg-light">
        <div class="row mb-4 gx-5">
            <div class="col-md-6 mb-4">
                <label class="fw-bold text-dark">Nama</label>
                <div class="text-secondary border-bottom pb-1">
                    {{ $question->nama }}
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <label class="fw-bold text-dark">Email</label>
                <div class="text-secondary border-bottom pb-1">
                    {{ $question->email }}
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <label class="fw-bold text-dark">Pertanyaan</label>
                <div class="text-secondary border-bottom pb-1">
                    {{ $question->pertanyaan }}
                </div>
            </div>
            @if ($question->jawaban)
            <div class="col-md-12 mb-4">
                <label class="fw-bold text-dark">Jawaban</label>
                <div class="text-secondary border-bottom pb-1">
                    {{ $question->jawaban }}
                </div>
            </div>
            @endif
            <div class="col-md-6 mb-4">
                <label class="fw-bold text-dark">Status Tampil ke Publik</label>
                <div class="text-secondary border-bottom pb-1">
                    <span class="badge {{ $question->is_published ? 'bg-success' : 'bg-secondary' }}">
                        {{ $question->is_published ? 'Tampil (FAQ)' : 'Tidak Ditampilkan' }}
                    </span>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <label class="fw-bold text-dark">Tanggal Dikirim</label>
                <div class="text-secondary border-bottom pb-1">
                    {{ \Carbon\Carbon::parse($question->created_at)->translatedFormat('d F Y H:i') }}
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('contactuses.index') }}" class="btn btn-secondary px-4 py-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection