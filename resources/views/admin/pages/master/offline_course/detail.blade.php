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
        @livewire('admin.offline-course.detail', ['offlineCourse' => $offlineCourse])
    </div>

@stop

@push('css')
    @livewireStyles
@endpush

@push('js')
    @livewireScripts
@endpush
