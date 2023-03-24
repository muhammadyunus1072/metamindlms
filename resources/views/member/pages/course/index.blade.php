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

                            @foreach ($results_data as $v)
                                @include('member.layouts.components.card_course_simple', [
                                    'v' => $v
                                ])
                            @endforeach 

                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col">
                    <div class="page-separator">
                        <div class="page-separator__text">Kursus Terbaru</div>
                    </div>
                </div>

                <div class="col-auto">
                    <a href="" class="btn btn-link btn-sm"><u>Lihat Terbaru</u></a>
                </div>
            </div>

            <div class="mb-lg-8pt">

                <div class="position-relative carousel-card">
                    <div class="js-mdk-carousel row d-block"
                         id="newest_course">

                        <a class="carousel-control-next js-mdk-carousel-control mt-n24pt"
                           href="#newest_course"
                           role="button"
                           data-slide="next">
                            <span class="carousel-control-icon material-icons"
                                  aria-hidden="true">keyboard_arrow_right</span>
                            <span class="sr-only">Next</span>
                        </a>

                        <div class="mdk-carousel__content">

                            @foreach ($results_data as $v)
                                @include('member.layouts.components.card_course', [
                                    'v' => $v,
                                    'is_new' => true
                                ])
                            @endforeach 

                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col">
                    <div class="page-separator">
                        <div class="page-separator__text">Rating Tertinggi</div>
                    </div>
                </div>

                <div class="col-auto">
                    <a href="" class="btn btn-link btn-sm"><u>Lihat Rating Tertinggi</u></a>
                </div>
            </div>

            <div class="mb-lg-8pt">

                <div class="position-relative carousel-card">
                    <div class="js-mdk-carousel row d-block"
                         id="high_rate_course">

                        <a class="carousel-control-next js-mdk-carousel-control mt-n24pt"
                           href="#high_rate_course"
                           role="button"
                           data-slide="next">
                            <span class="carousel-control-icon material-icons"
                                  aria-hidden="true">keyboard_arrow_right</span>
                            <span class="sr-only">Next</span>
                        </a>

                        <div class="mdk-carousel__content">

                            @foreach ($results_data as $v)
                                @include('member.layouts.components.card_course', [
                                    'v' => $v
                                ])
                            @endforeach 

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@stop

@section('filter')
    @include('member.layouts.filter')
<<<<<<< HEAD
@endsection
=======
@endsection

@section('js')
    @include('member.layouts.components.js_action_favorite')
@stop
>>>>>>> 41afe7b466e6580738e08754d2a0d7fa471c7d0d
