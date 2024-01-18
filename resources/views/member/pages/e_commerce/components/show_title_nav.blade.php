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
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $results_data->course->rating())
                            <span class="rating__item"><span class="material-icons">star</span></span>
                        @else
                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                        @endif
                    @endfor
                </div>
                <p class="lh-1 mb-0"><small class="text-muted">{{ $results_data->course->review() }} ulasan</small></p>
            </li>
        </ul>
    </div>
</div>