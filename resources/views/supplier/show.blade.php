@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            @if (empty($supplier))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> Data yang Anda cari tidak ditemukan.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tbody>
                        <tr>
                            <th style="width: 20%;">ID</th>
                            <td>{{ $supplier->supplier_id }}</td>
                        </tr>
                        <tr>
                            <th>Nama Supplier</th>
                            <td>{{ $supplier->supplier_nama }}</td>
                        </tr>
                        <tr>
                            <th>Kode Supplier</th>
                            <td>{{ $supplier->supplier_kode }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Supplier</th>
                            <td>{{ $supplier->supplier_alamat }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif

            <a href="{{ url('supplier') }}" class="btn btn-sm btn-default mt-3">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection

@push('css')
    {{-- Tambahkan custom CSS di sini jika diperlukan --}}
@endpush

@push('js')
    {{-- Tambahkan custom JavaScript di sini jika diperlukan --}}
@endpush