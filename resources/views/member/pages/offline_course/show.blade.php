@extends('member.layouts.index')

@section('content')
    @livewire('member.offline-course.show', ['offlineCourse' => $offlineCourse])
@stop


@push('js')
    @include('member.layouts.components.js_action_favorite')
@endpush
