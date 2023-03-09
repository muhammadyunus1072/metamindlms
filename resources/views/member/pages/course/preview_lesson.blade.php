@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')
    <?php 
        $list_route = array(
            'back' => $data['croute'] . 'show/' . enc($results_data->course_id),
        );
    ?>

    @include('member.pages.course.components.show_top_nav')

    <div class="bg-primary pb-lg-64pt py-32pt">
        <div class="container page__container">
            @if ($results_data->url_video)
                <div class="js-player embed-responsive embed-responsive-16by9 mb-32pt">
                    <iframe class="embed-responsive-item" src="{{ $results_data->url_video }}" allowfullscreen=""></iframe>
                </div>
            @endif

            <div class="d-flex flex-wrap align-items-end mb-16pt">
                <h1 class="text-white flex m-0">{{ $results_data->title }}</h1>
            </div>
            
        </div>
    </div>

    @include('member.pages.course.components.show_title_nav')  
    
    @include('member.pages.course.components.show_detail_lesson')    

@stop


@section('js')
@stop