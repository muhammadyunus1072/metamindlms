<div>
    <div class="col-md-6">
        <a href="#" data-target="#library-drawer" data-toggle="sidebar" class="btn btn-sm btn-white ml-sm-16pt">
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
                                        id="{{ $item->name }}"
                                        wire:click="$emit('add_filter_category', {{ $item->id }})">
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
