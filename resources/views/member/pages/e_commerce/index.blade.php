@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php
    $list_route = [
        'search' => $data['croute'] . 'search',
    ];
    ?>

    <div class="page-section">
        @livewire('member.e-commerce.index')
    </div>
@stop

@section('filter')
    @include('member.layouts.filter')
@endsection

@push('js')
    @include('member.layouts.components.js_action_favorite')
@endpush
