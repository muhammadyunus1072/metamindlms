@extends('member.layouts.index')

@section('content')
    <div class="page-section">
        <div class="container page__container">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h2>BERHASIL</h2>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('ic_success.png') }}" width="100px">
                    <h4 class="text-center mt-4">{{ !empty($success) ? $success : '' }}</h4>
                    <a class="btn btn-primary" href="{{ $url_show }}">Lihat Detail Kursus Offline</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('adminlte_css')
@stop

@section('adminlte_js')
@stop
