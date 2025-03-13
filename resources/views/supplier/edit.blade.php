@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            @if (empty($supplier))
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('supplier') }}" class="btn btn-sm btn-secondary mt-2">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            @else
                <form method="POST" action="{{ url('/supplier/' . $supplier->supplier_id) }}" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="supplier_nama" class="col-md-2 col-form-label">Nama Supplier</label>
                        <div class="col-md-10">
                            <input type="text" 
                                   class="form-control @error('supplier_nama') is-invalid @enderror" 
                                   id="supplier_nama" 
                                   name="supplier_nama" 
                                   value="{{ old('supplier_nama', $supplier->supplier_nama) }}" 
                                   placeholder="Masukkan Nama Supplier" 
                                   required>
                            @error('supplier_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="supplier_alamat" class="col-md-2 col-form-label">Alamat Supplier</label>
                        <div class="col-md-10">
                            <input type="text" 
                                   class="form-control @error('supplier_alamat') is-invalid @enderror" 
                                   id="supplier_alamat" 
                                   name="supplier_alamat" 
                                   value="{{ old('supplier_alamat', $supplier->supplier_alamat) }}" 
                                   placeholder="Masukkan Alamat Supplier" 
                                   required>
                            @error('supplier_alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="supplier_kode" class="col-md-2 col-form-label">Kode Supplier</label>
                        <div class="col-md-10">
                            <input type="text" 
                                   class="form-control @error('supplier_kode') is-invalid @enderror" 
                                   id="supplier_kode" 
                                   name="supplier_kode" 
                                   value="{{ old('supplier_kode', $supplier->supplier_kode) }}" 
                                   placeholder="Masukkan Kode Supplier" 
                                   required>
                            @error('supplier_kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                            <a href="{{ url('supplier') }}" class="btn btn-secondary btn-sm ml-1">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush