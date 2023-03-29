@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $list_route = array(
            'create_discussion' => route('member.discussion.index') . '/create/' . enc($results_data->id),
            'back' => $data['croute'] . 'show/' . enc($results_data->course_id),
            'finish_lesson' => $data['croute'] . 'finish_lesson/' . enc($results_data->id),
        );
    ?>

    @include('member.pages.course.components.show_top_nav')

    <div class="bg-primary pb-lg-64pt py-32pt">
        <div class="container page__container">
            <nav class="course-nav">
                @foreach ($list_lesson as $k=>$v)

                    @if ($v->id === $results_data->id)
                        <?php
                            if($k !== 0){
                                $list_route['previous_page'] = $data['croute'] . 'show_lesson/' . enc($list_lesson[$k-1]->id);
                            }

                            if(($k + 1) !== count($list_lesson)){
                                $list_route['next_page'] = $data['croute'] . 'show_lesson/' . enc($list_lesson[$k+1]->id);
                            }
                        ?>
                    @endif

                    <a data-toggle="tooltip"
                        data-placement="bottom"
                        data-title="{{ $v->title }}"
                        href="{{ $data['croute'] . 'show_lesson/' . enc($v->id) }}"><span class="material-icons">{{ $v->lesson_icon_learning(info_user_id()) }}</span>
                    </a>
                @endforeach
            </nav>

            @if ($results_data->url_video)
                <div class="js-player embed-responsive embed-responsive-16by9 mb-32pt">
                    <iframe class="embed-responsive-item" src="{{ $results_data->url_video }}" allowfullscreen=""></iframe>
                </div>
            @endif

            <div class="d-flex flex-wrap align-items-end mb-16pt">
                <h1 class="text-white flex m-0">{{ $results_data->title }}</h1>
            </div>

            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-start">
                @if(array_key_exists('previous_page', $list_route))
                    <a href="{{ $list_route['previous_page'] }}"
                        class="btn btn-outline-white mb-16pt mb-sm-0 mr-sm-16pt"><i class="material-icons icon--left">arrow_left</i>Sebelumnya</a>
                @endif

                @if (!$results_data->is_done_by_user(info_user_id()))
                    <a id="btn_finish_lesson" name="btn_finish_lesson"
                        class="btn btn-outline-white mb-16pt mb-sm-0 mr-sm-16pt"><i class="material-icons icon--left">check_circle</i>Selesai</a>
                @endif

                @if(array_key_exists('next_page', $list_route))
                    <a href="{{ $list_route['next_page'] }}"
                        class="btn btn-outline-white mb-16pt mb-sm-0 mr-sm-16pt">Selanjutnya <i class="material-icons icon--right">arrow_right</i></a>
                @endif
                
            </div>
        </div>
    </div>

    @include('member.pages.course.components.show_title_nav')
    
    @include('member.pages.course.components.show_detail_lesson')

    <div class="page-section bg-white">
        <div class="container page__container">

            <div class="d-flex align-items-center mb-heading">
                <h4 class="m-0">Forum Diskusi</h4>
                <a href="{{ $list_route['create_discussion'] }}"
                    class="text-underline ml-auto">Berikan Pertanyaan</a>
            </div>

            <div class="border-top">

                @livewire('discussion', ['lesson_id' => $results_data->id])

            </div>

            <a href="discussions.html"
                class="btn btn-outline-secondary">Lihat semua diskusi</a>

        </div>
    </div>

@stop

@push('js')
    <script>
        $("#btn_finish_lesson").click(function() {
            var url = "{{ $list_route['finish_lesson'] }}";

            var file_data = new FormData();

            action_table(file_data, url, 'page');
        });
    </script>
@endpush