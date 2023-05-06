<div class="row justify-content-center">
    {{-- Filter Search --}}
    <div class="col">
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
        </div>
    </div>

    {{-- Filter Category --}}
    <div class="col-md-auto">
        <a href="#" data-target="#library-drawer" data-toggle="sidebar" class="btn btn-sm btn-white">
            <i class="material-icons icon--left">tune</i> Filters
        </a>

        <div class="mdk-drawer js-mdk-drawer " id="library-drawer" data-align="end">
            <div class="mdk-drawer__content ">
                <div class="sidebar sidebar-light sidebar-right py-16pt" data-perfect-scrollbar
                    data-perfect-scrollbar-wheel-propagation="true">
                    <div class="sidebar-heading">Kategori</div>
                    <div class="sidebar-block">
                        @foreach ($categories as $item)
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" value="{{ $item->id }}"
                                        id="{{ $item->name }}" wire:click="toggle_filter_category({{ $item->id }})">
                                    <label class="custom-control-label" for="{{ $item->name }}">
                                        <span
                                            class="material-icons sidebar-menu-icon sidebar-menu-icon--left">brush</span>
                                        <span class="sidebar-menu-text">{{ $item->name }}</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
