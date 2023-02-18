@extends('layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')
    <div class="page-section">
        <div class="container page__container">

           @include('pages.course.components.filter_text')

            <div class="page-separator">
                <div class="page-separator__text">Semua Kursus</div>
            </div>

            <div class="row card-group-row">
                @foreach ($results_data as $v)
                    <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                        <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card"
                            data-toggle="popover"
                            data-trigger="click">

                            <a href="student-course.html"
                            class="card-img-top js-image"
                            data-position=""
                            data-height="140">
                                <img src="{{ asset('/assets/images/paths/mailchimp_430x168.png') }}"
                                    alt="course">
                                <span class="overlay__content">
                                    <span class="overlay__action d-flex flex-column text-center">
                                        <i class="material-icons icon-32pt">play_circle_outline</i>
                                        <span class="card-title text-white">Preview</span>
                                    </span>
                                </span>
                            </a>

                            <div class="card-body flex">
                                <div class="d-flex">
                                    <div class="flex">
                                        <a class="card-title"
                                        href="student-course.html">{{ $v->title }}</a>
                                        <small class="text-50 font-weight-bold mb-4pt">{{ $v->level_name }}</small>
                                    </div>
                                    
                                    @include('pages.course.components.favorite_action', [
                                        'is_favorite' => false
                                    ])
                                    
                                </div>
                                <div class="d-flex">
                                    <div class="rating flex">
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    </div>
                                    <!-- <small class="text-50">6 hours</small> -->
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-between">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                                        <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                                        <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="popoverContainer d-none">
                            <div class="media">
                                <div class="media-left mr-12pt">
                                    <img src="../../public/images/paths/angular_40x40@2x.png"
                                        width="40"
                                        height="40"
                                        alt="Angular"
                                        class="rounded">
                                </div>
                                <div class="media-body">
                                    <div class="card-title mb-0">{{ $v->title }}</div>
                                    <p class="lh-1 mb-0">
                                        <span class="text-50 small font-weight-bold">{{ $v->level_name }}</span>
                                    </p>
                                </div>
                            </div>

                            <p class="my-16pt text-70">{{ $v->description }}</p>

                            <div class="mb-16pt">
                                @foreach ($v->learn_description as $y)
                                    <div class="d-flex align-items-top">
                                        <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                        <p class="flex text-50 lh-1 mb-0 text-justify"><small>{{ $y->description }}</small></p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center mb-4pt">
                                        <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                                        <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                                    </div>
                                    <div class="d-flex align-items-center mb-4pt">
                                        <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                                        <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                                        <p class="flex text-50 lh-1 mb-0"><small>Beginner</small></p>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <a href="{{ route('course.show', enc($v->id)) }}"
                                        class="btn btn-primary">Lihat Trailer</a>
                                </div>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
@stop

@section('filter')
    @include('layouts.filter')
@endsection

@section('js')
@stop