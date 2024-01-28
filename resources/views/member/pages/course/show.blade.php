@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php
    $list_route = [];
    ?>

    <div class="mdk-box bg-primary js-mdk-box mb-0"
        style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),url({{ $data['files_course'] . $results_data->url_image }}); background-size: cover;"
        data-effects="blend-background">

        <div class="mdk-box__content">
            <div class="hero py-64pt text-center text-sm-left">
                <div class="container page__container">
                    <h1 class="text-white">{{ $results_data->title }}</h1>
                    <p class="lead text-white-50 measure-hero-lead">{{ $results_data->description }}</p>
                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-start">
                        <a onclick="show_trailer('{{ enc($results_data->id) }}')"
                            class="btn btn-outline-white mb-16pt mb-sm-0 mr-sm-16pt">Lihat trailer <i
                                class="material-icons icon--right">play_circle_outline</i></a>
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
                    <i class="material-icons text-muted icon--left">assessment</i>
                    {{ $results_data->level_name }}
                </li>
                <li class="nav-item ml-sm-auto text-sm-center flex-column navbar-list__item">
                    <div class="rating rating-24">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $results_data->rating())
                                <span class="rating__item"><span class="material-icons">star</span></span>
                            @else
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                            @endif
                        @endfor
                    </div>
                    <p class="lh-1 mb-0"><small class="text-muted">{{ $results_data->review() }} ulasan</small></p>
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

                    <div class="accordion js-accordion accordion--boxed list-group-flush" id="parent">

                        @foreach ($section_data as $k => $v)
                            <?php $index = $k + 1; ?>
                            <div class="accordion__item">
                                <a href="#" class="accordion__toggle collapsed" data-toggle="collapse"
                                    data-target="#course-toc-{{ $index }}" data-parent="#parent">
                                    <span class="flex">{{ $index . '. ' . $v->title }}</span>
                                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                                </a>
                                <div class="accordion__menu collapse" id="course-toc-{{ $index }}">

                                    @foreach ($v->lesson_active as $y)
                                        <div class="accordion__menu-link">
                                            <span
                                                class="icon-holder icon-holder--small icon-holder--primary rounded-circle d-inline-flex icon--left">
                                                <i class="material-icons icon-16pt">{{ $y->lesson_icon(false) }}</i>
                                            </span>
                                            @if ($y->can_preview)
                                                <a class="flex text-primary"
                                                    href="{{ $data['croute'] . 'preview_lesson/' . enc($y->id) }}">{{ $y->title }}</a>
                                            @else
                                                <a class="flex text-muted">{{ $y->title }}</a>
                                            @endif
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="col-lg-5 justify-content-center">

                    <div class="card">
                        <div class="card-body py-16pt">
                            @if ($results_data->price_before_discount)
                                <h4 class="p-0 m-0"><del>Rp{{ numberf($results_data->price_before_discount) }}<del></h4>
                            @endif
                            <h2>Rp{{ numberf($results_data->price) }}</h2>

                            @if (Auth::check() && info_user()->role == 'member')
                                <a class="btn btn-block btn-primary mb-2"
                                    onclick="action_product_cart('{{ enc($results_data->product->id) }}', true)">Beli
                                    Sekarang</a>
                                <a class="btn btn-block btn-success mb-3"
                                    onclick="action_product_cart('{{ enc($results_data->product->id) }}', false)">Tambah Ke
                                    Keranjang</a>
                            @endif

                            <h6 class="card-title mb-2">Kursus ini mencakup</h6>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center mb-8pt">
                                        <span class="material-icons icon-16pt mr-8pt">format_list_bulleted</span>
                                        <p class="flex lh-1 mb-0">{{ count($section_data) . ' Konten' }}</p>
                                    </div>
                                    <div class="d-flex align-items-center mb-8pt">
                                        <span class="material-icons icon-16pt mr-8pt">play_circle_outline</span>
                                        <p class="flex lh-1 mb-0">{{ count($lesson_course_data) . ' Pelajaran' }}</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-icons icon-16pt mr-8pt">assessment</span>
                                        <p class="flex lh-1 mb-0">{{ $results_data->level_name }}</p>
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
                        <div class="page-separator__text bg-white">Apa yang akan anda pelajari</div>
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

        <div class="container page__container">
            <div class="page-headline text-center">
                <h2>Review</h2>
            </div>

            <div class="page-separator">
                <div class="page-separator__text">Review Peserta</div>
            </div>
            <div class="row mb-32pt">
                <div class="col-md-3 mb-32pt mb-md-0">
                    <div class="display-1">{{ number_rating($results_data->rating()) }}</div>
                    <div class="rating rating-24">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $results_data->rating())
                                <span class="rating__item"><span class="material-icons">star</span></span>
                            @else
                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                            @endif
                        @endfor
                    </div>
                    <p class="text-muted mb-0">{{ $results_data->review() }} ulasan</p>
                </div>
                <div class="col-md-9">

                    <div class="row align-items-center mb-8pt" data-toggle="tooltip"
                        data-title="{{ $results_data->rating_by_star(5) }} ulasan" data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar"
                                    aria-valuenow="{{ $results_data->avg_rating_by_star(5) }}"
                                    style="width: {{ $results_data->avg_rating_by_star(5) }}%" aria-valuemin="0"
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
                    <div class="row align-items-center mb-8pt" data-toggle="tooltip"
                        data-title="{{ $results_data->rating_by_star(4) }} ulasan" data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar"
                                    aria-valuenow="{{ $results_data->avg_rating_by_star(4) }}"
                                    style="width: {{ $results_data->avg_rating_by_star(4) }}%" aria-valuemin="0"
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
                    <div class="row align-items-center mb-8pt" data-toggle="tooltip"
                        data-title="{{ $results_data->rating_by_star(3) }} ulasan" data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar"
                                    aria-valuenow="{{ $results_data->avg_rating_by_star(3) }}"
                                    style="width: {{ $results_data->avg_rating_by_star(3) }}%" aria-valuemin="0"
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
                    <div class="row align-items-center mb-8pt" data-toggle="tooltip"
                        data-title="{{ $results_data->rating_by_star(2) }} ulasan" data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar"
                                    aria-valuenow="{{ $results_data->avg_rating_by_star(2) }}"
                                    style="width: {{ $results_data->avg_rating_by_star(2) }}%" aria-valuemin="0"
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
                    <div class="row align-items-center mb-8pt" data-toggle="tooltip"
                        data-title="{{ $results_data->rating_by_star(1) }} ulasan" data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar"
                                    aria-valuenow="{{ $results_data->avg_rating_by_star(1) }}"
                                    style="width: {{ $results_data->avg_rating_by_star(1) }}%" aria-valuemin="0"
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

            @livewire('review', ['course_id' => $results_data->id])

        </div>

    </div>

    <div class="page-section bg-white">
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
                    <div class="js-mdk-carousel row d-block" id="popular_carousel">

                        <a class="carousel-control-next js-mdk-carousel-control mt-n24pt" href="#popular_carousel"
                            role="button" data-slide="next">
                            <span class="carousel-control-icon material-icons"
                                aria-hidden="true">keyboard_arrow_right</span>
                            <span class="sr-only">Next</span>
                        </a>

                        <div class="mdk-carousel__content">

                            @foreach ($popular_course_data as $v)
                                @include('member.layouts.components.card_course', [
                                    'v' => $v,
                                ])
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@stop

@section('modal')
    @include('member.layouts.components.modal_trailer')
@endsection

@push('js')
    @include('member.layouts.components.js_action_favorite')
    @include('member.layouts.components.js_action_product_to_cart')
    @include('member.layouts.components.js_show_trailer')
@endpush
