{{-- Filter --}}
<div>
    <a href="#" data-target="#library-drawer" data-toggle="sidebar" class="btn btn-primary mb-2">
        <i class="material-icons icon--left">tune</i>
        Filter Kategori Kursus Offline
    </a>

    <div class="mdk-drawer js-mdk-drawer " id="library-drawer" data-align="end">
        <div class="mdk-drawer__content ">
            <div class="sidebar sidebar-light sidebar-right" data-perfect-scrollbar
                data-perfect-scrollbar-wheel-propagation="true">
                <div class="sidebar-heading">Kategori</div>
                <div class="sidebar-block">
                    @foreach ($categories as $item)
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox"
                                    value="{{ Crypt::encrypt($item->id) }}" id="{{ $item->name }}"
                                    wire:click="$emit('filter_category', {{ $item->id }})">
                                <label class="custom-control-label" for="{{ $item->name }}">
                                    <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">brush</span>
                                    <span class="sidebar-menu-text">{{ $item->name }}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
