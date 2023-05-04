@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php
    $list_route = [
        'search' => '',
    ];
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
                <div class="page-separator__text">Kursus Offline Saya</div>
            </div>

            <div class="row card-group-row">
                @forelse ($offline_courses as $item)
                    @include('member.pages.dashboard.components.card_offline_course', ['item' => $item])
                @empty
                    <div class="col-md-12">
                        <h3 class="text-center">Belum Terdapat Kursus Offline Yang Diikuti</h3>
                    </div>
                @endforelse
            </div>
            <div>
                {{ $offline_courses->links() }}
            </div>

            <div class="page-separator">
                <div class="page-separator__text">Kursus Saya</div>
            </div>

            <div class="row card-group-row">
                @forelse ($courses as $v)
                    @include('member.pages.dashboard.components.card_course', [
                        'v' => $v,
                    ])
                @empty
                    <div class="col-md-12">
                        <h3 class="text-center">Belum Terdapat Kursus Online Yang Diikuti</h3>
                    </div>
                @endforelse
            </div>
            <div>
                {{ $courses->links() }}
            </div>


        </div>
    </div>

@stop

@section('filter')
    @include('member.layouts.filter')
@endsection

@push('js')
    @include('member.layouts.components.js_action_favorite')
@endpush
