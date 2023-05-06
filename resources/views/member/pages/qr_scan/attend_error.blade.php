@extends('member.layouts.index')

@section('content')
    <div class="page-section">
        <div class="container page__container">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h2>GAGAL</h2>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('ic_error.png') }}" width="100px">
                    <h4 class="text-center mt-4">{{ $error }}</h4>
                    <a class="btn btn-primary" href="{{ route('member.qr_scan.index') }}">Kembali Ke Scanner</a>
                </div>
            </div>
        </div>
    </div>
@stop
