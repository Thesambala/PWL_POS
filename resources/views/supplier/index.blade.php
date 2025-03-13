@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('supplier/create') }}" class="btn btn-sm btn-primary mt-1">
                    <i class="fa fa-plus"></i> Tambah
                </a>
            </div>
        </div>

        <div class="card-body">
            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Notifikasi error --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Tabel data supplier --}}
            <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier" style="width: 100%;">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th>Nama Supplier</th>
                        <th style="width: 15%;">Kode</th>
                        <th>Alamat</th>
                        <th class="text-center" style="width: 18%;">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
    {{-- Custom CSS (jika ada) --}}
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            $('#table_supplier').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('supplier/list') }}",
                    type: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "supplier_nama", orderable: true, searchable: true },
                    { data: "supplier_kode", orderable: true, searchable: true },
                    { data: "supplier_alamat", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ],
                order: [[1, 'asc']], // default sorting berdasarkan nama supplier
                responsive: true,
                autoWidth: false
            });
        });
    </script>
@endpush