@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('level/create') }}" class="btn btn-sm btn-primary mt-1">Tambah</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Level</th>
                        <th>Kode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            $('#table_level').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('level/list') }}",
                    type: "POST",
                    dataType: "json",
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "level_nama", orderable: true, searchable: true },
                    { data: "level_kode", orderable: true, searchable: true },
                    { data: "aksi", orderable: false, searchable: false, className: "text-center" }
                ]
            });
        });
    </script>
@endpush