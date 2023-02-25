@if (Auth::check())
    <a href="student-course.html"
        data-toggle="tooltip"
        data-title="{{ $is_favorite ? 'Tambahkan' :  'Hapuskan' }} sebagai Favorite"
        data-placement="top"
        data-boundary="window"
        class="ml-4pt material-icons text-20 card-course__icon-favorite">{{ $is_favorite ? 'favorite' :  'favorite_border' }}</a>
@endif