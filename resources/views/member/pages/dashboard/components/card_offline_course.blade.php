<div class="col-md-4">
    <div class="card card-sm card--elevated p-relative card-group-row__card" data-toggle="popover" data-trigger="click">
        <a href="" class="card-img-top">
            <center>
                <img src="{{ asset('attachments/files/offline_course/' . $item->image) }}" class="mt-3" height="150px"
                    alt="offline course">
            </center>
            <span class="overlay__content">
                <span class="overlay__action d-flex flex-column text-center">
                    <i class="material-icons icon-32pt">play_circle_outline</i>
                    <span class="card-title text-white">Preview</span>
                </span>
            </span>
        </a>

        <div class="card-body">
            <div class="d-flex">
                <div class="flex">
                    <p class="card-title">{{ $item->title }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-auto d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-4pt">people</span>
                    <p class="flex text-50 lh-1 mb-0">
                        <small>Kuota: {{ $item->quota }}</small>
                    </p>
                    {{-- @foreach ($categories as $key => $name)
                        {{ $name }}
                    @endforeach --}}
                </div>
            </div>
        </div>
    </div>
    <div class="popoverContainer d-none">
        <div class="media">
            <div class="media-left mr-12pt">
                <img src="{{ asset('attachments/files/offline_course/' . $item->image) }}" width="40" height="40"
                    alt="" class="rounded">
            </div>
            <div class="media-body">
                <div class="card-title mb-0">{{ $item->title }}</div>
            </div>
        </div>

        <p class="my-16pt text-70">{{ $item->description }}</p>

        <div class="row align-items-center">
            <div class="col-auto">
                <div class="d-flex align-items-center mb-4pt">
                    <span class="material-icons icon-16pt text-50 mr-4pt">people</span>
                    <p class="flex text-50 lh-1 mb-0">
                        <small>Kuota: {{ $item->quota }}</small>
                    </p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                    <p class="flex text-50 lh-1 mb-0">
                        <small>Mulai Kursus :
                            {{ Carbon\Carbon::parse($item->date_time_start)->format('d/m/Y') }}</small>
                    </p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                    <p class="flex text-50 lh-1 mb-0">
                        <small>Berakhir Kursus :
                            {{ Carbon\Carbon::parse($item->date_time_end)->format('d/m/Y') }}</small>
                    </p>
                </div>
            </div>
            <div class="col text-right mt-3">
                <a href="{{ route('offline_course.show', Crypt::encrypt($item->id)) }}" class="btn btn-primary">Lihat
                    Kursus</a>
            </div>
        </div>
    </div>
</div>
