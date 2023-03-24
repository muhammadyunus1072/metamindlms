<div>
    @foreach ($list_discussion_data as $v)
        <div class="list-group-item p-3">
            <div class="row align-items-start">
                <div class="col-md-3 mb-8pt mb-md-0">
                    <div class="media align-items-center">
                        <div class="media-left mr-12pt">
                            @include('member.layouts.components.img_users')
                        </div>
                        <div class="d-flex flex-column media-body media-middle">
                            <a
                                class="card-title">{{ $v->member_name }}</a>
                            <small class="text-muted">{{ time_diff_for_human($v->created_at) }}</small>
                        </div>
                    </div>
                </div>
                <div class="col mb-8pt mb-md-0">
                    <p class="mb-8pt"><a href="{{ $data['croute'] . 'show/' . enc($v->id) }}"
                            class="text-body"><strong>{{ $v->title }}</strong></a></p>

                </div>
                <div class="col-auto d-flex flex-column align-items-center justify-content-center">
                    <h5 class="m-0">{{ count($v->discussion_answer) }}</h5>
                    <p class="lh-1 mb-0"><small class="text-70">Pembahasan</small></p>
                </div>
            </div>
        </div>
    @endforeach

    {{ $list_discussion_data->links('pagination.livewire_pagination') }}
</div>
