<div>
    <div class="mdk-box bg-primary js-mdk-box mb-0"
        style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),url({{ $image }}); background-size: cover;"
        data-effects="blend-background">

        <div class="mdk-box__content">
            <div class="hero py-64pt text-center text-sm-left">
                <div class="container page__container">
                    <h1 class="text-white">{{ $title }}</h1>
                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-start">
                        <a href="{{ route('member.qr_scan.index') }}"
                            class="btn btn-outline-white mb-16pt mb-sm-0 mr-sm-16pt">
                            Scan QR-CODE
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-section border-bottom-2">
        <div class="container page__container">
            {{-- ATTACHMENT --}}
            @if (count($attachments) > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="p-0 m-0">Lampiran</h5>
                    </div>
                    <div class="card-header">
                        @foreach ($attachments as $index => $item)
                            <div class="row border rounded align-items-center p-2 ml-2 mr-2">
                                <div class="col">
                                    <h5 class="p-0 m-0">{{ $index + 1 }}. {{ $item['title'] }}</h5>
                                </div>
                                <div class="col-auto">
                                    <a target="_blank" href="{{ $item['file'] }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-file mr-1"></i>
                                        Buka File
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- LINK --}}
            @if (count($links) > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="p-0 m-0">Materi Bacaan</h5>
                    </div>
                    <div class="card-header">
                        @foreach ($links as $index => $item)
                            <div class="row border rounded align-items-center p-2 ml-2 mr-2">
                                <div class="col">
                                    <h5 class="p-0 m-0">{{ $index + 1 }}. {{ $item['title'] }}</h5>
                                </div>
                                <div class="col-auto">
                                    <a target="_blank" href="{{ $item['url'] }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-link mr-1"></i>
                                        Buka Link
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- VIDEO --}}
            @if (count($videos) > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="p-0 m-0">Materi Video</h5>
                    </div>
                    <div class="card-header">
                        @foreach ($videos as $index => $item)
                            <div class="row border rounded align-items-center p-2 ml-2 mr-2">
                                <div class="col">
                                    <h5 class="p-0 m-0">{{ $index + 1 }}. {{ $item['title'] }}</h5>
                                </div>
                                <div class="col-auto">
                                    <a target="_blank" href="{{ $item['video'] }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-link mr-1"></i>
                                        Buka Link
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="page-separator">
                <div class="page-separator__text">Konten kursus</div>
            </div>
            <div class="row mb-0">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <img class="img-fluid" src="{{ $image }}"
                                style="max-height:200px; object-fit:contain">
                            <div class="form-group">
                                <label class="form-label">Kategori</label>
                                <br>
                                @foreach ($categories as $key => $name)
                                    <div class="btn btn-outline-info btn-sm mt-1">{{ $name }}</div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label class="form-label">Judul :</label>
                                <h4>{{ $title }}</h4>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="description">Deskripsi :</label>
                                <h6>{{ $description }}</h6>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="border rounded p-2 bg-info">
                                        <label class="form-label text-white">Quota :</label>
                                        <h5 class="mb-0 text-white">{{ $quota }}</h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-2 bg-primary">
                                        <label class="form-label text-white">Mulai :</label>
                                        <h5 class="mb-0 text-white">
                                            {{ Carbon\Carbon::parse($date_time_start)->format('d M Y, H:i') }}</h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-2 bg-success">
                                        <label class="form-label text-white">Selesai :</label>
                                        <h5 class="mb-0 text-white">
                                            {{ Carbon\Carbon::parse($date_time_end)->format('d M Y, H:i') }}</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                {!! $content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
