@extends('admin.layouts.index')

@section('content')
    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Produk</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">
                            Produk
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row" role="tablist">
                <div class="col-auto">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-outline-secondary">Tambah</a>
                </div>
            </div>
        </div>
    </div>

    <div class="page__container page-section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List Data Produk</h4>
            </div>
            <div class="card-body">
                @livewire('admin.product.datatable')
            </div>
        </div>
    </div>

@stop

@push('css')
    @livewireStyles
@endpush

@push('js')
    @livewireScripts
@endpush
