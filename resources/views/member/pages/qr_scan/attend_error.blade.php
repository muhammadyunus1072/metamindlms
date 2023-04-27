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
                    <p class="text-justify mt-4">{{ $error }}</p>
                </div>
            </div>
        </div>
    </div>
@stop
