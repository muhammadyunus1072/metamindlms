@extends('member.layouts.index')

@section('content')
    <div class="page-section">
        <div class="container page__container">

        </div>
    </div>
@stop

@section('filter')
    @include('member.layouts.filter')
@endsection

@push('js')
    @include('member.layouts.components.js_action_favorite')
@endpush
