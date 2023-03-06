@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $list_route = array(
            'favorite' => route('course.index') . '/store_favorite',

            'course_member' => route('member.course_member.index'),
        );
    ?>

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
                    <a href="{{ $list_route['course_member'] }}"
                        class="btn btn-outline-secondary">Kursus Saya</a>
                </div>
            </div>

        </div>
    </div>

    <div class="container page__container">
        <div class="page-section">

            <div class="page-separator">
                <div class="page-separator__text">Pelajaran Terakhir Saya</div>
            </div>

            <div class="page-separator">
                <div class="page-separator__text">Kursus Saya</div>
            </div>

            <div class="position-relative carousel-card">
                <div class="js-mdk-carousel row d-block"
                     id="course_member">

                    <a class="carousel-control-next js-mdk-carousel-control mt-n24pt"
                       href="#course_member"
                       role="button"
                       data-slide="next">
                        <span class="carousel-control-icon material-icons"
                              aria-hidden="true">keyboard_arrow_right</span>
                        <span class="sr-only">Next</span>
                    </a>

                    <div class="mdk-carousel__content">

                        @foreach ($course_member as $v)
                            @include('member.pages.dashboard.components.card_course_member', [
                                'v' => $v
                            ])
                        @endforeach 

                    </div>
                </div>
            </div>

            <div class="page-separator">
                <div class="page-separator__text">Diskusi Saya</div>
            </div>

            <div class="card">

                <div class="list-group list-group-flush">

                    <div class="list-group-item p-3">
                        <div class="row align-items-start">
                            <div class="col-md-3 mb-8pt mb-md-0">
                                <div class="media align-items-center">
                                    <div class="media-left mr-12pt">
                                        <a href=""
                                           class="avatar avatar-sm">
                                            <!-- <img src="../../LB" alt="avatar" class="avatar-img rounded-circle"> -->
                                            <span class="avatar-title rounded-circle">LB</span>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column media-body media-middle">
                                        <a href=""
                                           class="card-title">Laza Bogdan</a>
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-8pt mb-md-0">
                                <p class="mb-8pt"><a href="discussion.html"
                                       class="text-body"><strong>Using Angular HttpClientModule instead of HttpModule</strong></a></p>

                                <a href="discussion.html"
                                   class="chip chip-outline-secondary">Angular fundamentals</a>

                            </div>
                            <div class="col-auto d-flex flex-column align-items-center justify-content-center">
                                <h5 class="m-0">1</h5>
                                <p class="lh-1 mb-0"><small class="text-70">answers</small></p>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item p-3">
                        <div class="row align-items-start">
                            <div class="col-md-3 mb-8pt mb-md-0">
                                <div class="media align-items-center">
                                    <div class="media-left mr-12pt">
                                        <a href=""
                                           class="avatar avatar-sm">
                                            <!-- <img src="../../AC" alt="avatar" class="avatar-img rounded-circle"> -->
                                            <span class="avatar-title rounded-circle">AC</span>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column media-body media-middle">
                                        <a href=""
                                           class="card-title">Adam Curtis</a>
                                        <small class="text-muted">3 days ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-8pt mb-md-0">
                                <p class="mb-0"><a href="discussion.html"
                                       class="text-body"><strong>Why am I getting an error when trying to install angular/http@2.4.2</strong></a></p>

                            </div>
                            <div class="col-auto d-flex flex-column align-items-center justify-content-center">
                                <h5 class="m-0">1</h5>
                                <p class="lh-1 mb-0"><small class="text-70">answers</small></p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer p-8pt">

                    <ul class="pagination justify-content-start pagination-xsm m-0">
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
    </div>

@stop

@section('js')
    @include('member.layouts.components.js_action_favorite')
@stop