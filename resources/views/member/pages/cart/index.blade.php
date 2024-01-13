@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')
    <?php
    $list_route = [
        'favorite' => route('course.index') . '/store_favorite',
        'course_member' => route('member.course_member.index'),
    ];
    ?>
    <div class="pt-32pt">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">cart</h2>
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">
                            cart
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row" role="tablist">
                <div class="col-auto">
                    <a href="{{ $list_route['course_member'] }}" class="btn btn-outline-secondary">Kursus Saya</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container page__container">
        @livewire('member.cart.index')
    </div>
@stop

@push('js')
    @include('member.layouts.components.js_action_favorite')
@endpush
