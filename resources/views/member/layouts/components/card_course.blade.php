<div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card"
        data-toggle="popover"
        data-trigger="click">

        <a href=""
            class="card-img-top js-image"
            data-position=""
            data-height="140">
            <img src="{{ $data['files_course'] . $v->url_image }}" height="150px"
                alt="course">
            <span class="overlay__content">
                <span class="overlay__action d-flex flex-column text-center">
                    <i class="material-icons icon-32pt">play_circle_outline</i>
                    <span class="card-title text-white">Preview</span>
                </span>
            </span>
        </a>

        @if (isset($is_new))
            <span class="corner-ribbon corner-ribbon--default-right-top corner-ribbon--shadow bg-accent text-white">BARU</span>
        @endif

        <div class="card-body flex">
            <div class="d-flex">
                <div class="flex">
                    <a class="card-title"
                    href="">{{ $v->title }}</a>
                    <small class="text-50 font-weight-bold mb-4pt">{{ $v->level_name }}</small>
                </div>
                
                @if (Auth::check())
                    <a
                        data-toggle="tooltip"
                        title="{{ $v->is_favorite() ? 'Hapuskan dari' :  'Tambahkan ke' }} Favorite"
                        data-placement="top"
                        data-boundary="window"
                        class="ml-4pt material-icons text-20 card-course__icon-favorite"
                        onclick="action_favorite('{{ enc($v->id) }}', this)"
                        >{{ $v->is_favorite() ? 'favorite' :  'favorite_border' }}</a>
                @endif

            </div>
            <div class="d-flex">
                <div class="rating flex">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $v->rating())
                            <span class="rating__item"><span class="material-icons">star</span></span>
                        @else
                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-auto d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-4pt">format_list_bulleted</span>
                    <p class="flex text-50 lh-1 mb-0"><small>{{ count($v->course_sections) }} Konten</small></p>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                    <p class="flex text-50 lh-1 mb-0"><small>{{ count($v->lessons) }} Pelajaran</small></p>
                </div>
            </div>
        </div>
    </div>
    <div class="popoverContainer d-none">
        <div class="media">
            <div class="media-left mr-12pt">
                <img src="{{ $data['files_course'] . $v->url_image }}"
                    width="40"
                    height="40"
                    alt=""
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
                    <span class="material-icons icon-16pt text-50 mr-4pt">format_list_bulleted</span>
                    <p class="flex text-50 lh-1 mb-0"><small>{{ count($v->course_sections) }} Konten</small></p>
                </div>
                <div class="d-flex align-items-center mb-4pt">
                    <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                    <p class="flex text-50 lh-1 mb-0"><small>{{ count($v->lessons) }} Pelajaran</small></p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                    <p class="flex text-50 lh-1 mb-0"><small>{{ $v->level_name }}</small></p>
                </div>
            </div>
            <div class="col text-right">
                <a href="{{ route('course.show', enc($v->id)) }}"
                class="btn btn-primary">Lihat trailer</a>
            </div>
        </div>

    </div>

</div>