@extends('member.layouts.index')

@section('content')
    <div class="page-section">
        <div class="container page__container">
            <div class="row">
                <div class="col">
                    <a class="btn btn-block {{ Request::segment(1) == 'course' ? 'btn-primary' : 'btn-white' }}"
                        href="{{ route('course.index') }}">
                        Kursus Online
                    </a>
                </div>
                <div class="col">
                    <a class="btn btn-block {{ Request::segment(1) == 'offline_course' ? 'btn-primary' : 'btn-white' }}"
                        href="{{ route('course.index', ['type' => 'offline']) }}">
                        Kursus Offline
                    </a>
                </div>
            </div>
            <hr>

            @livewire('member.offline-course.filter-offline-course')
            @livewire('member.offline-course.index')
        </div>
    </div>
@stop

@push('js')
@endpush
