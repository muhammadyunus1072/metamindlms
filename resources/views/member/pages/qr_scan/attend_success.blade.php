@extends('member.layouts.index')

@section('content')
    <div class="page-section">
        <div class="container page__container">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h2>BERHASIL</h2>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('ic_error.png') }}" width="100px">
                    <p class="text-justify mt-4">{{ !empty($success) ? $success : '' }}</p>
                </div>
            </div>
        </div>
    </div>
@stop


@section('body')
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="card shadow">
            <div class="card-header text-center">
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('ic_success.png') }}" width="100px">
                <p class="text-justify mt-4">{{ !empty($success) ? $success : '' }}</p>
            </div>
        </div>
    </div>
@stop

@section('adminlte_css')
@stop

@section('adminlte_js')
@stop
