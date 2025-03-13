@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('supplier') }}" class="form-horizontal">
                @csrf

                <div class="form-group row">
                    <label for="supplier_nama" class="col-md-2 col-form-label">Nama Supplier</label>
                    <div class="col-md-10">
                        <input type="text" 
                               class="form-control @error('supplier_nama') is-invalid @enderror" 
                               id="supplier_nama" 
                               name="supplier_nama"
                               value="{{ old('supplier_nama') }}" 
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
                               value="{{ old('supplier_alamat') }}" 
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
                               value="{{ old('supplier_kode') }}" 
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
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush