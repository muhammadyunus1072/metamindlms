@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $list_route = array(
            'search' => '',
        );
    ?>

    <div class="pt-32pt">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Kursus Saya</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>

                        <li class="breadcrumb-item active">

                            Kursus Saya

                        </li>

                    </ol>

                </div>
            </div>

        </div>
    </div>

    <div class="container page__container">
        <div class="page-section">

            @include('member.pages.course.components.filter_text')

            <div class="page-separator">
                <div class="page-separator__text">Kursus Saya</div>
            </div>

            @if (count($results_data) > 0)
                <div class="row card-group-row">
                    @foreach ($results_data as $v)
                        @include('member.pages.dashboard.components.card_course_member', [
                            'v' => $v
                        ])
                    @endforeach
                </div>
            @else
                <p class="text-muted">Kursus tidak ditemukan.</p>
            @endif


        </div>
    </div>

@stop

@section('filter')
    @include('member.layouts.filter')
@endsection

@push('js')
    @include('member.layouts.components.js_action_favorite')
@endpush