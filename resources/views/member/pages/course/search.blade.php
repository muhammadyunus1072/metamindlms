@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')
    <?php 
        $list_route = array(
            'search' => $data['croute'] . 'search'
        );
    ?>

    <div class="page-section">
        <div class="container page__container">

            @include('member.pages.course.components.filter_text')

            <div class="page-separator">
                <div class="page-separator__text">Semua Kursus</div>
            </div>

            @if (count($results_data) > 0)
                <div class="row card-group-row">
                    @foreach ($results_data as $v)
                        @include('member.layouts.components.card_course', [
                            'v' => $v
                        ])
                    @endforeach
                </div>

                {{ $results_data->appends(request()->query())->links('pagination.pagination') }}
            @else
                <p class="text-muted">Kursus tidak ditemukan.</p>
            @endif

        </div>
    </div>
@stop

@section('filter')
    @include('member.layouts.filter')
@endsection

@section('js')
    @include('member.layouts.components.js_action_favorite')
@stop