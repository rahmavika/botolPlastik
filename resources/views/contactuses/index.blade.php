@extends('layouts.main')

@section('title', 'Data Pertanyaan')
@section('navContactUs', 'active')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex--md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pertanyaan Masuk</h1>
</div>
<a href="{{ route('contactuses.cetak_pdf') }}" target="_blank" class="btn btn-outline-danger mb-3">
    <i class='bx bxs-file-pdf'></i> Cetak PDF
</a>
<table id="pertanyaanTable" class="table table-dashboard">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Pertanyaan</th>
            <th>Jawaban</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($questions as $question)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $question->nama }}</td>
            <td>{{ $question->email }}</td>
            <td>{{ Str::limit($question->pertanyaan, 50) }}</td>
            <td>{{ $question->jawaban ? Str::limit($question->jawaban, 50) : '-' }}</td>
            <td class="text-nowrap">
                <a href="{{ route('contactuses.edit', $question->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $question->id }}">
                    <i class="bi bi-trash-fill"></i>
                </button>
                <form id="form-delete-{{ $question->id }}" action="{{ route('contactuses.destroy', $question->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-delete-' + id).submit();
                    }
                });
            });
        });

        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#0B773D'
            });
        @endif

        $('#pertanyaanTable').DataTable({
            paging: true,
            searching: true,
            ordering:  true,
            lengthChange: true,
            language: {
                "sSearch": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush
@endsection
