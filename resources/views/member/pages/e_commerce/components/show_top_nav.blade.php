<div class="navbar navbar-light bg-white border-0 navbar-expand">
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