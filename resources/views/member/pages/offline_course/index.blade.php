@extends('member.layouts.index')

@section('content')
    <div class="page-section">
        <div class="container page__container">
            @livewire('member.offline-course.filter-offline-course')
            @livewire('member.offline-course.index')
        </div>
    </div>
@stop

@push('js')
@endpush