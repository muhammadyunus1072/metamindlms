@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')
    <?php 
        $list_route = array(
            'back' => $data['croute'] . 'show/' . enc($results_data->course_id),
            'favorite' => $data['croute'] . 'store_favorite',
        );
    ?>

    <div class="navbar navbar-light border-0 navbar-expand">
        <div class="container page__container">
            <div class="media flex-nowrap">
                <div class="media-left mr-16pt">
                    <div class="d-flex d-inline">

                        <a href="{{ $list_route['back'] }}" class="my-auto mr-4"><span><i class="fas fa-arrow-left fa-lg"></i></span></a>

                        <a href=""><img src="{{ $data['files_course'] . $results_data->course_url_image }}"
                                    height="40px"
                                    alt=""
                                    class="rounded"></a>
                    </div>
                </div>
                <div class="media-body">
                    <a href=""
                        class="card-title text-body mb-0">{{ $results_data->course_title }}</a>
                    <p class="lh-1 d-flex align-items-center mb-0">
                        <span class="text-50 small">{{ $results_data->level_name }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-primary pb-lg-64pt py-32pt">
        <div class="container page__container">
            @if ($results_data->url_video)
                <div class="js-player embed-responsive embed-responsive-16by9 mb-32pt">
                    <iframe class="embed-responsive-item" src="{{ $results_data->url_video }}" allowfullscreen=""></iframe>
                </div>
            @else
                <div class="text-justify bg-white p-4 overflow-auto" style="height: 500px">
                    <?= $results_data->description ?>
                </div>
            @endif

            <div class="d-flex flex-wrap align-items-end mb-16pt">
                <h1 class="text-white flex m-0">{{ $results_data->title }}</h1>
            </div>

            @if ($results_data->url_video)
                <p class="hero__lead text-white-50 mb-24pt text-justify">{{ $results_data->description }}</p>
            @endif
            
        </div>
    </div>

    <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
        <div class="container page__container">
            <ul class="nav navbar-nav flex align-items-sm-center">
                <li class="nav-item navbar-list__item">
                    <div class="media align-items-center">
                        {{-- <span class="media-left mr-16pt">
                            <img src="../../public/images/people/50/guy-6.jpg"
                                    width="40"
                                    alt="avatar"
                                    class="rounded-circle">
                        </span> --}}
                        <div class="media-body">
                            <p class=" card-title m-0 lead text-70 measure-lead mx-auto">{{ $results_data->course_title }}</p>
                        </div>
                    </div>
                </li>
                <li class="nav-item navbar-list__item">
                    <i class="material-icons text-muted icon--left">assessment</i>
                    {{ $results_data->level_name }}
                </li>
                <li class="nav-item ml-sm-auto text-sm-center flex-column navbar-list__item">
                    <div class="rating rating-24">
                        <div class="rating__item"><i class="material-icons">star</i></div>
                        <div class="rating__item"><i class="material-icons">star</i></div>
                        <div class="rating__item"><i class="material-icons">star</i></div>
                        <div class="rating__item"><i class="material-icons">star</i></div>
                        <div class="rating__item"><i class="material-icons">star_border</i></div>
                    </div>
                    <p class="lh-1 mb-0"><small class="text-muted">20 ratings</small></p>
                </li>
            </ul>
        </div>
    </div>
@stop


@section('js')
@stop