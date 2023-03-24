<div class="pt-3">
    <h4>{{ count($discussion_answer_data) . ' Pembahasan' }}</h4>
    
    @if (count($discussion_answer_data) > 0)
        @foreach ($discussion_answer_data as $v)
            <div class="d-flex mb-3">
                @include('member.layouts.components.img_users')
                <div class="flex">
                    <a
                    class="text-body"><strong>{{ $v->member_name }}</strong></a><br>
                    <p class="mt-1 text-70">{{ $v->answer }}</p>
                    <div class="d-flex align-items-center">
                        <small class="text-50 mr-2">{{ time_diff_for_human($v->created_at) }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-muted">Belum ada pembahasan.</p>
    @endif
</div>