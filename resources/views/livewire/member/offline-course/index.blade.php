<div>
    {{-- Search & Filter --}}
    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-24pt" style="white-space: nowrap;">
        <div class="form-group flex mr-3 mb-2 mb-sm-0">
            <div class="row">
                <div class="col-lg">
                    <div class="search-form form-control-rounded search-form--dark">
                        <input id="search" type="text" class="form-control" placeholder="Cari Kursus"
                            wire:model='search'><i class="material-icons">search</i>
                    </div>
                </div>
            </div>
        </div>

        <a href="#" data-target="#library-drawer" data-toggle="sidebar" class="btn btn-sm btn-white ml-sm-16pt">
            <i class="material-icons icon--left">tune</i> Filters
        </a>

        <div class="mdk-drawer js-mdk-drawer " id="library-drawer" data-align="end">
            <div class="mdk-drawer__content ">
                <div class="sidebar sidebar-light sidebar-right py-16pt" data-perfect-scrollbar
                    data-perfect-scrollbar-wheel-propagation="true">

                    <div class="d-flex align-items-center mb-24pt  d-lg-none">
                        <form action="index.html" class="search-form search-form--light mx-16pt pr-0 pl-16pt">
                            <input type="text" class="form-control pl-0" placeholder="Search">
                            <button class="btn" type="submit"><i class="material-icons">search</i></button>
                        </form>
                    </div>

                    <form action="" class="m-0" id="form_search">
                        <div class="sidebar-heading">Kategori</div>
                        <div class="sidebar-block">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" value="semua"
                                        id="category_filter_all" name="category_filter[]"
                                       >
                                    <label class="custom-control-label" for="category_filter_all">
                                        <span
                                            class="material-icons sidebar-menu-icon sidebar-menu-icon--left">brush</span>
                                        <span class="sidebar-menu-text">Semua</span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
                            <button type="submit" class="btn btn-block btn-outline-primary mb-3">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Card --}}
    <div class="row">
        <div class="col">
            <div class="page-separator">
                <div class="page-separator__text">Kursus yang akan berjalan</div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse ($data as $item)
            <div class="col-md-4">
                <div class="card card-sm card--elevated p-relative card-group-row__card" data-toggle="popover"
                    data-trigger="click">
                    <a href="" class="card-img-top">
                        <center>
                            <img src="{{ asset('attachments/files/offline_course/' . $item->image) }}" class="mt-3"
                                height="150px" alt="offline course">
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
                            <img src="{{ asset('attachments/files/offline_course/' . $item->image) }}" width="40"
                                height="40" alt="" class="rounded">
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
                                    <small>Mulai Kursus : {{ Carbon\Carbon::parse($item->date_time_start)->format('d/m/Y') }}</small>
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
                            <a href="{{ route('offline_course.show', Crypt::encrypt($item->id)) }}" class="btn btn-primary">Lihat Kursus</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <h3 class="text-center">Data Tidak Tersedia</h3>
            </div>
        @endforelse
        {{ $data->links() }}
    </div>
</div>
