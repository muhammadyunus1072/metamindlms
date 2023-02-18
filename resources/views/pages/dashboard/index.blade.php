@extends('layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <div class="pt-32pt">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Dashboard</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>

                        <li class="breadcrumb-item active">

                            Dashboard

                        </li>

                    </ol>

                </div>
            </div>

            <div class="row"
                    role="tablist">
                <div class="col-auto">
                    <a href="student-my-courses.html"
                        class="btn btn-outline-secondary">My Courses</a>
                </div>
            </div>

        </div>
    </div>

        <div class="container page__container">
            <div class="page-section">

                <div class="page-separator">
                    <div class="page-separator__text">Overview</div>
                </div>

                <div class="row mb-lg-8pt">
                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <div class="h2 mb-0 mr-3">116</div>
                                <div class="flex">
                                    <p class="card-title">Angular</p>
                                    <p class="card-subtitle text-50">Best score</p>
                                </div>
                                <div class="dropdown">
                                    <a href="#"
                                        class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                        data-toggle="dropdown">Popular Topics</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href=""
                                            class="dropdown-item">Popular Topics</a>
                                        <a href=""
                                            class="dropdown-item">Web Design</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-24pt">
                                <div class="chart"
                                        style="height: 344px;">
                                    <canvas id="topicIqChart"
                                            class="chart-canvas js-update-chart-line"
                                            data-chart-hide-axes="true"
                                            data-chart-points="true"
                                            data-chart-suffix=" points"
                                            data-chart-line-border-color="primary"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-header d-flex align-items-center border-0">
                                <div class="h2 mb-0 mr-3">432</div>
                                <div class="flex">
                                    <p class="card-title">Experience IQ</p>
                                    <p class="card-subtitle text-50">4 days streak this week</p>
                                </div>
                                <i class="material-icons text-muted ml-2">trending_up</i>
                            </div>
                            <div class="card-body pt-0">
                                <div class="chart"
                                        style="height: 128px;">
                                    <canvas id="iqChart"
                                            class="chart-canvas js-update-chart-line"
                                            data-chart-hide-axes="false"
                                            data-chart-points="true"
                                            data-chart-suffix="pt"
                                            data-chart-line-border-color="primary"></canvas>
                                </div>
                            </div>
                        </div>

                        <div id="carouselExampleFade"
                                class="carousel carousel-card slide mb-24pt">
                            <div class="carousel-inner">

                                <div class="carousel-item active">

                                    <a class="card border-0 mb-0"
                                        href="">
                                        <img src="../../public/images/achievements/flinto.png"
                                                alt="Flinto"
                                                class="card-img"
                                                style="max-height: 100%; width: initial;">
                                        <div class="fullbleed bg-primary"
                                                style="opacity: .5;"></div>
                                        <span class="card-body d-flex flex-column align-items-center justify-content-center fullbleed">
                                            <span class="row flex-nowrap">
                                                <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                                                    <span class="h5 text-white text-uppercase font-weight-normal m-0 d-block">Achievement</span>
                                                    <span class="text-white-60 d-block mb-24pt">Jun 5, 2018</span>
                                                </span>
                                                <span class="col d-flex flex-column">
                                                    <span class="text-right flex mb-16pt">
                                                        <img src="../../public/images/paths/flinto_40x40@2x.png"
                                                                width="64"
                                                                alt="Flinto"
                                                                class="rounded">
                                                    </span>
                                                </span>
                                            </span>
                                            <span class="row flex-nowrap">
                                                <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                                                    <img src="../../public/images/illustration/achievement/128/white.png"
                                                            width="64"
                                                            alt="achievement">
                                                </span>
                                                <span class="col d-flex flex-column">
                                                    <span>
                                                        <span class="card-title text-white mb-4pt d-block">Flinto</span>
                                                        <span class="text-white-60">Introduction to The App Design Application</span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </a>

                                </div>

                                <div class="carousel-item">

                                    <a class="card border-0 mb-0"
                                        href="">
                                        <img src="../../public/images/achievements/angular.png"
                                                alt="Angular fundamentals"
                                                class="card-img"
                                                style="max-height: 100%; width: initial;">
                                        <div class="fullbleed bg-primary"
                                                style="opacity: .5;"></div>
                                        <span class="card-body d-flex flex-column align-items-center justify-content-center fullbleed">
                                            <span class="row flex-nowrap">
                                                <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                                                    <span class="h5 text-white text-uppercase font-weight-normal m-0 d-block">Achievement</span>
                                                    <span class="text-white-60 d-block mb-24pt">Jun 5, 2018</span>
                                                </span>
                                                <span class="col d-flex flex-column">
                                                    <span class="text-right flex mb-16pt">
                                                        <img src="../../public/images/paths/angular_64x64.png"
                                                                width="64"
                                                                alt="Angular fundamentals"
                                                                class="rounded">
                                                    </span>
                                                </span>
                                            </span>
                                            <span class="row flex-nowrap">
                                                <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                                                    <img src="../../public/images/illustration/achievement/128/white.png"
                                                            width="64"
                                                            alt="achievement">
                                                </span>
                                                <span class="col d-flex flex-column">
                                                    <span>
                                                        <span class="card-title text-white mb-4pt d-block">Angular fundamentals</span>
                                                        <span class="text-white-60">Creating and Communicating Between Angular Components</span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </a>

                                </div>

                            </div>
                            <a class="carousel-control-next"
                                href="#carouselExampleFade"
                                role="button"
                                data-slide="next">
                                <span class="carousel-control-icon material-icons"
                                        aria-hidden="true">keyboard_arrow_right</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                    </div>
                </div>


            </div>
        </div>

@stop

@section('js')
@stop