<div>
    @if (count($list_discussion_data) > 0)
        <div class="list-group list-group-flush">
            @foreach ($list_discussion_data as $v)
                <div class="list-group-item p-3">
                    <div class="row align-items-start">
                        <div class="col-md-3 mb-8pt mb-md-0">
                            <div class="media align-items-center">
                                <div class="media-left mr-12pt">
                                    <a
                                        class="avatar avatar-sm mr-12pt">
                                        <span class="avatar-title rounded-circle">
                                            <span class="material-icons">person</span>
                                        </span>
                                    </a>
                                </div>
                                <div class="d-flex flex-column media-body media-middle">
                                    <a href=""
                                        class="card-title">{{ $v->member_name }}</a>
                                    <small class="text-muted">{{ time_diff_for_human($v->created_at) }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-8pt mb-md-0">
                            <p class="mb-0"><a href="{{ route('member.discussion.show', enc($v->id)) }}"
                                    class="text-body"><strong>{{ $v->title }}</strong></a></p>

                        </div>
                        <div class="col-auto d-flex flex-column align-items-center justify-content-center">
                            <h5 class="m-0">{{ count($v->discussion_answer) }}</h5>
                            <p class="lh-1 mb-0"><small class="text-70">Pembahasan</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $list_discussion_data->links('pagination.livewire_pagination') }}
    @else
        <p class="text-muted mt-2">Belum ada diskusi.</p>
    @endif

</div>
