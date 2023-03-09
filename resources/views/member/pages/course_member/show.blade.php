@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <div class="mdk-box bg-primary mdk-box--bg-gradient-primary2 js-mdk-box mb-0"
        style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),url({{ $data['files_course'] . $results_data->url_image }}); background-size: cover;"
            data-effects="blend-background">
        <div class="mdk-box__content">
            <div class="hero py-64pt text-center text-sm-left">
                <div class="container page__container">
                    <h1 class="text-white">{{ $results_data->title }}</h1>
                    <p class="lead text-white-50 measure-hero-lead">{{ $results_data->description }}</p>
                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-start">
                        <a onclick="show_trailer('{{ enc($results_data->id) }}')"
                            class="btn btn-outline-white mb-16pt mb-sm-0 mr-sm-16pt">Lihat trailer <i class="material-icons icon--right">play_circle_outline</i></a>
                    </div>
                </div>
            </div>
            <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
                <div class="container page__container">
                    <ul class="nav navbar-nav flex align-items-sm-center">
                        <li class="nav-item navbar-list__item">
                            <div class="media align-items-center">
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
        </div>
    </div>

    <div class="container page__container">
        <div class="row">
            <div class="col-lg-7">
                <div class="border-left-2 page-section pl-32pt" data-bs-spy="scroll" data-bs-target="#navbar_section" data-bs-offset="0" tabindex="0">

                    @foreach ($section_data as $k=>$v)
                        <?php $index = $k+1; ?>
                        <div class="d-flex align-items-center page-num-container" id="section_{{ $index }}">
                            <div class="page-num">{{ $index }}</div>
                            <h4>{{ $v->title }}</h4>
                        </div>
                        
                        <div class="card mb-32pt mb-lg-64pt">
                            <ul class="accordion accordion--boxed js-accordion mb-0"
                                id="course-toc-{{ $index }}">
                                <li class="accordion__item open">
                                    <a class="accordion__toggle"
                                        data-toggle="collapse"
                                        data-parent="#course-toc-{{ $index }}"
                                        href="#course-content-{{ $index }}">
                                        <span class="flex">{{ $v->title }} ({{ count($v->lesson_status_by_user(info_user_id(), true)) }} dari {{ count($v->lesson_status_by_user(info_user_id())) }})</span>
                                        <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                                    </a>
                                    <div class="accordion__menu">
                                        <ul class="list-unstyled collapse show"
                                            id="course-content-{{ $index }}">
                                            @foreach ($v->lesson_active as $y)
                                                <li class="accordion__menu-link">
                                                    <span class="material-icons icon-16pt icon--left text-50">{{ $y->lesson_icon(true) }}</span>
                                                    <a class="flex"
                                                        href="{{ $data['croute'] . 'show_lesson/' . enc($y->id) }}">{{ $y->title }}</a>
                                                    @if ($y->is_done_by_user(info_user_id()))
                                                        <span><i class="fas fa-check-circle text-success fa-lg"></i></span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="col-lg-5 page-nav">
                <div class="page-section">
                    <div class="page-nav__content">
                        <div class="page-separator">
                            <div class="page-separator__text">Kategori</div>
                        </div>  

                        <ul>
                            @foreach ($category_data as $v)
                                <li class="text-muted">{{ $v->category_name }}</li>
                            @endforeach
                        </ul>

                        <div class="page-separator">
                            <div class="page-separator__text">Konten Kursus</div>
                        </div>  
                    </div>
                    <nav class="nav page-nav__menu custom_scrolling_navbar" id="navbar_section">
                        {{-- <a class="nav-link active"
                            href="">Getting Started With Angular</a> --}}
                        @foreach ($section_data as $k=>$v)
                            <a class="nav-link" href="#section_{{ $k+1 }}">{{ $v->title }}</a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-section bg-white border-top-2 border-bottom-2">

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
        <div class="container">
            <div class="page-headline text-center">
                <h2>Review</h2>

                @if ($review_data)
                    <div>
                        <p class="lead text-70 measure-lead mx-auto">Ulasan anda mengenai kursus ini.</p>
                        <div class="row">
                            <div class="col d-flex justify-content-center">
                                <div class="w-50">
                                    <div class="card card-feedback card-body">
                                        <blockquote class="blockquote mb-0">
                                            <p class="text-70 small mb-0 text-justify">{{ $review_data->comment }}</p>
                                        </blockquote>
                                    </div>
                                    <div class="media ml-12pt">
                                        {{-- <div class="media-left mr-12pt">
                                            <a href="student-profile.html"
                                                class="avatar avatar-sm">
                                                <!-- <img src="../../public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                                                <span class="avatar-title rounded-circle">UK</span>
                                            </a>
                                        </div> --}}
                                        <div class="media-body media-middle">
                                            <a href="student-profile.html"
                                                class="card-title">{{ $review_data->member_name }}</a>
                                            <div class="rating mt-4pt">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review_data->rating)
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                    @else
                                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div>
                        <p class="lead text-70 measure-lead mx-auto">Berikan ulasan anda mengenai kursus ini.</p>

                        <form id="form-review" name="form-review" action="{{ $data['croute'] . 'store_review/' . enc($results_data->id) }}">
                            <div class="form-group m-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="stars">
                                            <input class="star star-5" id="star-5" type="radio" name="rating_review" value="5"/>
                                            <label class="star star-5" for="star-5"></label>
                                        
                                            <input class="star star-4" id="star-4" type="radio" name="rating_review" value="4"/>
                                            <label class="star star-4" for="star-4"></label>
                                        
                                            <input class="star star-3" id="star-3" type="radio" name="rating_review" value="3"/>
                                            <label class="star star-3" for="star-3"></label>
                                        
                                            <input class="star star-2" id="star-2" type="radio" name="rating_review" value="2"/>
                                            <label class="star star-2" for="star-2"></label>
                                        
                                            <input class="star star-1" id="star-1" type="radio" name="rating_review" value="1"/>
                                            <label class="star star-1" for="star-1"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="form-group">
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <textarea class="form-control w-75 align-center" name="comment_review" id="comment_review" rows="8"></textarea>
                                    </div>
                                </div>
                            </div>
        
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary px-4" name="btn_store_review" id="btn_store_review">Simpan</button>
                            </div>
                        </form>
                    </div>
                @endif

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

                    <div class="row align-items-center mb-8pt"
                            data-toggle="tooltip"
                            data-title="{{ $results_data->rating_by_star(5) }} ulasan"
                            data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary"
                                        role="progressbar"
                                        aria-valuenow="{{ $results_data->avg_rating_by_star(5) }}"
                                        style="width: {{ $results_data->avg_rating_by_star(5) }}%"
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
                            data-title="{{ $results_data->rating_by_star(4) }} ulasan"
                            data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary"
                                        role="progressbar"
                                        aria-valuenow="{{ $results_data->avg_rating_by_star(4) }}"
                                        style="width: {{ $results_data->avg_rating_by_star(4) }}%"
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
                            data-title="{{ $results_data->rating_by_star(3) }} ulasan"
                            data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary"
                                        role="progressbar"
                                        aria-valuenow="{{ $results_data->avg_rating_by_star(3) }}"
                                        style="width: {{ $results_data->avg_rating_by_star(3) }}%"
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
                            data-title="{{ $results_data->rating_by_star(2) }} ulasan"
                            data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary"
                                        role="progressbar"
                                        aria-valuenow="{{ $results_data->avg_rating_by_star(2) }}"
                                        style="width: {{ $results_data->avg_rating_by_star(2) }}%"
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
                            data-title="{{ $results_data->rating_by_star(1) }} ulasan"
                            data-placement="top">
                        <div class="col-md col-sm-6">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary"
                                        role="progressbar"
                                        aria-valuenow="{{ $results_data->avg_rating_by_star(1) }}"
                                        style="width: {{ $results_data->avg_rating_by_star(1) }}%"
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

            @livewire('review', ['course_id' => $results_data->id])

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

@section('modal')
    @include('member.layouts.components.modal_trailer')
@endsection

@section('js')
    @include('member.layouts.components.js_action_favorite')
    @include('member.layouts.components.js_show_trailer')

    <script>
        $("#form-review").submit(function(e) {
            e.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');

            var file_data = new FormData();
            file_data.append('rating', $('input[name="rating_review"]:checked').val());
            file_data.append('comment', $('#comment_review').val());

            r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
        });
    </script>
@stop