<div>
    @foreach ($list_review_data as $v)
        <div class="pb-16pt mb-16pt border-bottom row">
            <div class="col-md-3 mb-16pt mb-md-0">
                <div class="d-flex">
                    <a href="student-profile.html"
                        class="avatar avatar-sm mr-12pt">
                        <!-- <img src="LB" alt="avatar" class="avatar-img rounded-circle"> -->
                        <span class="avatar-title rounded-circle">LB</span>
                    </a>
                    <div class="flex">
                        <p class="small text-muted m-0">{{ time_diff_for_human($v->created_at) }}</p>
                        <a class="card-title">{{ $v->member_name }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="rating mb-8pt">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $v->rating)
                            <span class="rating__item"><span class="material-icons">star</span></span>
                        @else
                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                        @endif
                    @endfor                 
                </div>
                <p class="text-70 mb-0">{{ $v->comment }}</p>
            </div>
        </div>
    @endforeach

    {{ $list_review_data->links('pagination.livewire_pagination') }}
</div>
