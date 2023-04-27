@extends('admin.layouts.index')

@section('content')
    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Kursus Offline</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">
                            Kursus Offline
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="page__container page-section">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h2 class="font-weight-bold text-center">{{ $offlineCourse->title }}</h2>
            </div>
            <div class="card-body mb-4">
                <h3 class="text-center mb-4">Scan Untuk Absen</h3>
                <div class="d-flex justify-content-center" id="qrcode"></div>
            </div>
        </div>
    </div>

@stop

@push('css')
@endpush

@push('js')
    <script src="{{ asset('vendor/qrcodegen/qrcode.min.js') }}"></script>
    <script>
        var isRequesting = false;

        $(function() {
            new QRCode(document.getElementById("qrcode"), "{{ $offlineCourse->url }}");
        })
    </script>
@endpush
