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

            @if (count($attachments) > 0)
                <div class="page-separator">
                    <div class="page-separator__text">Lampiran Kursus</div>
                </div>
                <div class="row mb-0">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Lampiran</label>
                                    <br>
                                    @foreach ($attachments as $item)
                                        <a target="_blank" href="{{ $item['file'] }}"
                                            class="btn btn-outline-primary ml-1 mt-1">
                                            {{ $item['file_name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
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
                                <label class="form-label" for="title">Judul :</label>
                                <h4>{{ $title }}</h4>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="title">Quota :</label>
                                <h5>{{ $quota }}</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Tanggal dan Waktu Mulai :</label>
                                        <h5>{{ $date_time_start }}</h5>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Tanggal dan Waktu Selesai :</label>
                                        <h5>{{ $date_time_end }}</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="description">Deskripsi :</label>
                                <h6>{{ $description }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
