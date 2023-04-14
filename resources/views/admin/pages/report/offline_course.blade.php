@extends('admin.layouts.index')

@section('content')
    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Laporan</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ 'admin' }}">Home</a></li>
                        <li class="breadcrumb-item active">
                            Laporan Kursus Offline
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="page__container page-section">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah Pendaftar</h5>
                    </div>
                    <div class="card-body">
                        <h4 class="text-center">{{ $total_offline_course_registrar }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah Kehadiran</h5>
                    </div>
                    <div class="card-body">
                        <h4 class="text-center">{{ $total_offline_course_attendance }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List Laporan Kursus Offline</h4>
            </div>
            <div class="card-body">
                @livewire('admin.report.filter-offline-course-datatable')
                @livewire('admin.report.offline-course-datatable')
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
