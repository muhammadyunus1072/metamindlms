<div class="container page__container">
    <div class="row">
        <div class="col-lg-7">
            <div class="page-section">
                <div class="page-nav__content">
                    <div class="page-separator">
                        <div class="page-separator__text">Deskripsi Kursus</div>
                    </div>  

                    <div class="row mb-0 text-justify">
                        <div class="col">
                            <?= $results_data->description ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 page-nav">
            <div class="page-section">
                <div class="page-nav__content">
                    <div class="page-separator">
                        <div class="page-separator__text">Lampiran</div>
                    </div>  

                    @if (count($lesson_file) > 0)
                        <ul>
                            @foreach ($lesson_file as $v)
                                <?php $url = $data['files_course'] . $v->files . '.' . $v->extension; ?>
                                <li class="text-muted">
                                    <a class="mb-4" href="{{ $url }}" target="_blank">
                                        {{ $v->files }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        Tidak ada lampiran.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>