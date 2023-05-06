<div>
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
