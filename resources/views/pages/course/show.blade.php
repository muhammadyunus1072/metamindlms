@extends('layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <div class="mdk-box bg-primary js-mdk-box mb-0"
            data-effects="blend-background">
        <div class="mdk-box__content">
            <div class="hero py-64pt text-center text-sm-left">
                <div class="container page__container">
                    <h1 class="text-white">{{ $results_data->title }}</h1>
                    <p class="lead text-white-50 measure-hero-lead">{{ $results_data->description }}</p>
                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-start">
                        <a href="student-lesson.html"
                            class="btn btn-outline-white mb-16pt mb-sm-0 mr-sm-16pt">Lihat trailer <i class="material-icons icon--right">play_circle_outline</i></a>
                    </div>
                </div>
            </div>
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
                            <p class=" card-title m-0 lead text-70 measure-lead mx-auto">{{ $results_data->title }}</p>
                        </div>
                    </div>
                </li>
                <li class="nav-item navbar-list__item">
                    <i class="material-icons text-muted icon--left">schedule</i>
                    2h 46m
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

    <div class="page-section border-bottom-2">
        <div class="container page__container">

            <div class="page-separator">
                <div class="page-separator__text">Konten kursus</div>
            </div>
            <div class="row mb-0">
                <div class="col-lg-7">

                    <div class="accordion js-accordion accordion--boxed list-group-flush"
                            id="parent">
                        <div class="accordion__item open">
                            <a href="#"
                                class="accordion__toggle"
                                data-toggle="collapse"
                                data-target="#course-toc-1"
                                data-parent="#parent">
                                <span class="flex">Getting Started with Angular</span>
                                <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                            </a>
                            <div class="accordion__menu collapse show"
                                    id="course-toc-1">
                                <div class="accordion__menu-link">
                                    <span class="icon-holder icon-holder--small icon-holder--dark rounded-circle d-inline-flex icon--left">
                                        <i class="material-icons icon-16pt">check_circle</i>
                                    </span>
                                    <a class="flex"
                                        href="student-lesson.html">Introduction</a>
                                    <span class="text-muted">8m 42s</span>
                                </div>
                                <div class="accordion__menu-link active">
                                    <span class="icon-holder icon-holder--small icon-holder--primary rounded-circle d-inline-flex icon--left">
                                        <i class="material-icons icon-16pt">play_circle_outline</i>
                                    </span>
                                    <a class="flex"
                                        href="student-lesson.html">Introduction to TypeScript</a>
                                    <span class="text-muted">50m 13s</span>
                                </div>
                                <div class="accordion__menu-link">
                                    <span class="icon-holder icon-holder--small icon-holder--light rounded-circle d-inline-flex icon--left">
                                        <i class="material-icons icon-16pt">lock</i>
                                    </span>
                                    <a class="flex"
                                        href="student-lesson.html">Comparing Angular to AngularJS</a>
                                    <span class="text-muted">12m 10s</span>
                                </div>
                                <div class="accordion__menu-link">
                                    <span class="icon-holder icon-holder--small icon-holder--light rounded-circle d-inline-flex icon--left">
                                        <i class="material-icons icon-16pt">hourglass_empty</i>
                                    </span>
                                    <a class="flex"
                                        href="student-take-quiz.html">Quiz: Getting Started With Angular</a>
                                </div>
                            </div>
                        </div>

                        @foreach ($section_data as $k=>$v)
                            <div class="accordion__item">
                                <a href="#"
                                    class="accordion__toggle collapsed"
                                    data-toggle="collapse"
                                    data-target="#course-toc-{{ $k+2 }}"
                                    data-parent="#parent">
                                    <span class="flex">{{ ($k+2).'. '.$v->title }}</span>
                                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                                </a>
                                <div class="accordion__menu collapse"
                                        id="course-toc-{{ $k+2 }}">
                                    <div class="accordion__menu-link">
                                        <span class="icon-holder icon-holder--small icon-holder--dark rounded-circle d-inline-flex icon--left">
                                            <i class="material-icons icon-16pt">play_circle_outline</i>
                                        </span>
                                        <a class="flex"
                                            href="student-lesson.html">Watch Trailer</a>
                                        <span class="text-muted">1m 10s</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="col-lg-5 justify-content-center">

                    <div class="card">
                        <div class="card-body py-16pt">
                            <h2>Rp{{ numberf($results_data->price) }}</h2>

                            <button class="btn btn-block btn-primary mb-3">Beli Sekarang</button>

                            <h6 class="card-title mb-2">Kursus ini mencakup</h6>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center mb-8pt">
                                        <span class="material-icons icon-16pt mr-8pt">access_time</span>
                                        <p class="flex lh-1 mb-0">6 hours</p>
                                    </div>
                                    <div class="d-flex align-items-center mb-8pt">
                                        <span class="material-icons icon-16pt mr-8pt">play_circle_outline</span>
                                        <p class="flex lh-1 mb-0">12 lessons</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-icons icon-16pt mr-8pt">assessment</span>
                                        <p class="flex lh-1 mb-0">Beginner</p>
                                    </div>
                                </div>
                            </div>
                            {{-- <span class="icon-holder icon-holder--outline-secondary rounded-circle d-inline-flex mb-8pt">
                                <i class="material-icons">timer</i>
                            </span>
                            <h4 class="card-title"><strong>Unlock Library</strong></h4>
                            <p class="card-subtitle text-70 mb-24pt">Get access to all videos in the library</p>
                            <a href="pricing.html"
                                class="btn btn-accent mb-8pt">Sign Up - Only $19.00/mo</a>
                            <p class="mb-0">Have an account? <a href="login.html">Login</a></p> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="page-section bg-white border-bottom-2">

        <div class="container page__container">
            <div class="row ">
                <div class="col-md-7">
                    <div class="page-separator">
                        <div class="page-separator__text">Tentang Kursus Ini</div>
                    </div>
                    <p class="text-70 mb-0 text-justify">
                        {{ $results_data->about }}
                    </p>
                </div>
                <div class="col-md-5">
                    <div class="page-separator">
                        <div class="page-separator__text bg-white">Apa yang akan ada pelajari</div>
                    </div>
                    <ul class="list-unstyled">
                        @foreach ($learn_description_data as $v)
                            <li class="d-flex align-items-top">
                                <span class="material-icons text-50 mr-8pt">check</span>
                                <span class="text-70">{{ $v->description }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <div class="page-section border-bottom-2">
        <div class="container">
            <div class="page-headline text-center">
                <h2>Review</h2>
                <p class="lead text-70 measure-lead mx-auto">Apa yang peserta lain katakan tentang kami setelah belajar bersama kami dan mencapai tujuan merekak.</p>
            </div>

            <div class="position-relative carousel-card p-0 mx-auto">
                <div class="row d-block js-mdk-carousel"
                        id="review_carousel">
                    <a class="carousel-control-next js-mdk-carousel-control mt-n24pt"
                        href="#review_carousel"
                        role="button"
                        data-slide="next">
                        <span class="carousel-control-icon material-icons"
                                aria-hidden="true">keyboard_arrow_right</span>
                        <span class="sr-only">Next</span>
                    </a>
                    <div class="mdk-carousel__content">

                        <div class="col-12 col-md-6">

                            <div class="card card-feedback card-body">
                                <blockquote class="blockquote mb-0">
                                    <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
                                </blockquote>
                            </div>
                            <div class="media ml-12pt">
                                <div class="media-left mr-12pt">
                                    <a href="student-profile.html"
                                        class="avatar avatar-sm">
                                        <!-- <img src="../../public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                                        <span class="avatar-title rounded-circle">UK</span>
                                    </a>
                                </div>
                                <div class="media-body media-middle">
                                    <a href="student-profile.html"
                                        class="card-title">Umberto Kass</a>
                                    <div class="rating mt-4pt">
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-md-6">

                            <div class="card card-feedback card-body">
                                <blockquote class="blockquote mb-0">
                                    <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
                                </blockquote>
                            </div>
                            <div class="media ml-12pt">
                                <div class="media-left mr-12pt">
                                    <a href="student-profile.html"
                                        class="avatar avatar-sm">
                                        <!-- <img src="../../public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                                        <span class="avatar-title rounded-circle">UK</span>
                                    </a>
                                </div>
                                <div class="media-body media-middle">
                                    <a href="student-profile.html"
                                        class="card-title">Umberto Kass</a>
                                    <div class="rating mt-4pt">
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-md-6">

                            <div class="card card-feedback card-body">
                                <blockquote class="blockquote mb-0">
                                    <p class="text-70 small mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
                                </blockquote>
                            </div>
                            <div class="media ml-12pt">
                                <div class="media-left mr-12pt">
                                    <a href="student-profile.html"
                                        class="avatar avatar-sm">
                                        <!-- <img src="../../public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                                        <span class="avatar-title rounded-circle">UK</span>
                                    </a>
                                </div>
                                <div class="media-body media-middle">
                                    <a href="student-profile.html"
                                        class="card-title">Umberto Kass</a>
                                    <div class="rating mt-4pt">
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-section bg-white border-bottom-2">

        <div class="container page__container">
            <div class="page-separator">
                <div class="page-separator__text">Review Peserta</div>
            </div>
            <div class="row mb-32pt">
                <div class="col-md-3 mb-32pt mb-md-0">
                    <div class="display-1">4.7</div>
                    <div class="rating rating-24">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                    </div>
                    <p class="text-muted mb-0">20 ratings</p>
                </div>
                <div class="col-md-9">

                    <div class="row align-items-center mb-8pt"
                            data-toggle="tooltip"
                            data-title="75% rated 5/5"
                            data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress"
                                    style="height: 8px;">
                                <div class="progress-bar bg-secondary"
                                        role="progressbar"
                                        aria-valuenow="75"
                                        style="width: 75%"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                            <div class="rating">
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-8pt"
                            data-toggle="tooltip"
                            data-title="16% rated 4/5"
                            data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress"
                                    style="height: 8px;">
                                <div class="progress-bar bg-secondary"
                                        role="progressbar"
                                        aria-valuenow="16"
                                        style="width: 16%"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                            <div class="rating">
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-8pt"
                            data-toggle="tooltip"
                            data-title="12% rated 3/5"
                            data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress"
                                    style="height: 8px;">
                                <div class="progress-bar bg-secondary"
                                        role="progressbar"
                                        aria-valuenow="12"
                                        style="width: 12%"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                            <div class="rating">
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-8pt"
                            data-toggle="tooltip"
                            data-title="9% rated 2/5"
                            data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress"
                                    style="height: 8px;">
                                <div class="progress-bar bg-secondary"
                                        role="progressbar"
                                        aria-valuenow="9"
                                        style="width: 9%"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                            <div class="rating">
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-8pt"
                            data-toggle="tooltip"
                            data-title="0% rated 0/5"
                            data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress"
                                    style="height: 8px;">
                                <div class="progress-bar bg-secondary"
                                        role="progressbar"
                                        aria-valuenow="0"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                            <div class="rating">
                                <span class="rating__item"><span class="material-icons">star</span></span>
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="pb-16pt mb-16pt border-bottom row">
                <div class="col-md-3 mb-16pt mb-md-0">
                    <div class="d-flex">
                        <a href="student-profile.html"
                            class="avatar avatar-sm mr-12pt">
                            <!-- <img src="LB" alt="avatar" class="avatar-img rounded-circle"> -->
                            <span class="avatar-title rounded-circle">LB</span>
                        </a>
                        <div class="flex">
                            <p class="small text-muted m-0">2 days ago</p>
                            <a href="student-profile.html"
                                class="card-title">Laza Bogdan</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="rating mb-8pt">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                    </div>
                    <p class="text-70 mb-0">A wonderful course on how to start. Eddie beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you Eddie Bryan.</p>
                </div>
            </div>

            <div class="pb-16pt mb-16pt border-bottom row">
                <div class="col-md-3 mb-16pt mb-md-0">
                    <div class="d-flex">
                        <a href="student-profile.html"
                            class="avatar avatar-sm mr-12pt">
                            <!-- <img src="UK" alt="avatar" class="avatar-img rounded-circle"> -->
                            <span class="avatar-title rounded-circle">UK</span>
                        </a>
                        <div class="flex">
                            <p class="small text-muted m-0">2 days ago</p>
                            <a href="student-profile.html"
                                class="card-title">Umberto Klass</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="rating mb-8pt">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                    </div>
                    <p class="text-70 mb-0">This course is absolutely amazing, Bryan goes* out of his way to really expl*ain things clearly I couldn&#39;t be happier, so glad I made this purchase!</p>
                </div>
            </div>

            <div class="pb-16pt mb-24pt row">
                <div class="col-md-3 mb-16pt mb-md-0">
                    <div class="d-flex">
                        <a href="student-profile.html"
                            class="avatar avatar-sm mr-12pt">
                            <!-- <img src="AD" alt="avatar" class="avatar-img rounded-circle"> -->
                            <span class="avatar-title rounded-circle">AD</span>
                        </a>
                        <div class="flex">
                            <p class="small text-muted m-0">2 days ago</p>
                            <a href="student-profile.html"
                                class="card-title">Adrian Demian</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="rating mb-8pt">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                    </div>
                    <p class="text-70 mb-0">This course is absolutely amazing, Bryan goes* out of his way to really expl*ain things clearly I couldn&#39;t be happier, so glad I made this purchase!</p>
                </div>
            </div>

            <div class="mb-32pt">

                <ul class="pagination justify-content-center pagination-xsm m-0">
                    <li class="page-item disabled">
                        <a class="page-link"
                           href="#"
                           aria-label="Previous">
                            <span aria-hidden="true"
                                  class="material-icons">chevron_left</span>
                            <span>Prev</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link"
                           href="#"
                           aria-label="Page 1">
                            <span>1</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link"
                           href="#"
                           aria-label="Page 2">
                            <span>2</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link"
                           href="#"
                           aria-label="Next">
                            <span>Next</span>
                            <span aria-hidden="true"
                                  class="material-icons">chevron_right</span>
                        </a>
                    </li>
                </ul>

            </div>

        </div>

    </div>

    <div class="page-section">
        <div class="container page__container">
            <div class="row">
                <div class="col">
                    <div class="page-separator">
                        <div class="page-separator__text">Kursus Terpopuler</div>
                    </div>
                </div>

                <div class="col-auto">
                    <a href="" class="btn btn-link btn-sm"><u>Lihat Terpopuler</u></a>
                </div>
            </div>

            <div class="mb-lg-8pt">

                <div class="position-relative carousel-card">
                    <div class="js-mdk-carousel row d-block"
                         id="popular_carousel">

                        <a class="carousel-control-next js-mdk-carousel-control mt-n24pt"
                           href="#popular_carousel"
                           role="button"
                           data-slide="next">
                            <span class="carousel-control-icon material-icons"
                                  aria-hidden="true">keyboard_arrow_right</span>
                            <span class="sr-only">Next</span>
                        </a>

                        <div class="mdk-carousel__content">

                            @foreach ($popular_course_data as $v)
                                <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal card-group-row__card"
                                            
                                            data-partial-height="44"
                                            data-toggle="popover"
                                            data-trigger="click">

                                        <a href="student-course.html"
                                            class="js-image"
                                            data-position="">
                                            <img src="{{ asset('/assets/images/paths/mailchimp_430x168.png') }}"
                                                    alt="course">
                                            <span class="overlay__content align-items-start justify-content-start">
                                                <span class="overlay__action card-body d-flex align-items-center">
                                                    <i class="material-icons mr-4pt">play_circle_outline</i>
                                                    <span class="card-title text-white">Preview</span>
                                                </span>
                                            </span>
                                        </a>

                                        <div class="mdk-reveal__content">
                                            <div class="card-body">
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
                                                    <small class="text-50">6 hours</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="popoverContainer d-none">
                                        <div class="media">
                                            <div class="media-left mr-12pt">
                                                <img src="../../public/images/paths/mailchimp_40x40@2x.png"
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

            </div>

        </div>
    </div>

@stop

@section('js')
@stop