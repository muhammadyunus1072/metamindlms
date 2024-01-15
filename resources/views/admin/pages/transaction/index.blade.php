@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')
    <div class="pt-32pt">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Transaksi</h2>
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">
                            Transaksi
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container page__container">
        @livewire('admin.transaction.index')
    </div>
@stop
