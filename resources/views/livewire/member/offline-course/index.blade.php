<div>
    {{-- Search --}}
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
            @include('member.pages.dashboard.components.card_offline_course', ['item' => $item])
        @empty
            <div class="col-md-12">
                <h3 class="text-center">Data Tidak Tersedia</h3>
            </div>
        @endforelse
        {{ $data->links() }}
    </div>
</div>
