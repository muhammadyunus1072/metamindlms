@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $list_route = array(
            'back' => route('member.course_member.index') . '/show/' . enc($results_data->course_id),
            'delete_discussion' => $data['croute'] . 'delete/' . enc($results_data->id),
        );
    ?>

    @include('member.pages.course.components.show_top_nav')

    <div class="container page__container">
        <div class="page-section">

            <div class="row">
                <div class="col">

                    <h1 class="h2 mb-2 text-justify">{{ $results_data->title }}</h1>
                    @if (info_user_id() === $results_data->created_by)
                        <p class="text-muted d-flex align-items-center mb-lg-32pt">
                            <a href="{{ $data['croute'] . 'edit/' . enc($results_data->id) }}"
                                class="text-50 mr-2"
                                style="text-decoration: underline;">Ubah</a>

                            <a id="btn_delete_discussion" name="btn_delete_discussion"
                                class="text-50 text-danger">Hapus</a>
                        </p>
                    @endif

                    <div class="card card-body">
                        <div class="d-flex">
                            @include('member.layouts.components.img_users')
                            <div class="flex">
                                <p class="d-flex align-items-center mb-2">
                                    <a
                                       class="text-body mr-2"><strong>{{ $results_data->member_name }}</strong></a>
                                    <small class="text-muted">{{ time_diff_for_human($results_data->created_at) }}</small>
                                </p>
                                {{ $results_data->description }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        @include('member.layouts.components.img_users')
                        <div class="flex">
                            <form action="{{ $data['croute'] . 'store_answer/' . enc($results_data->id) }}" id="form-data">
                                <div class="form-group">
                                    <label for="answer" class="form-label">Balasan Anda</label>
                                    <textarea class="form-control" name="answer" id="answer" rows="3"></textarea>
                                </div>
                                <button class="btn btn-outline-secondary" type="submit">Kirim</button>
                            </form>
                        </div>
                    </div>
                    
                    @include('member.pages.discussion.components.detail_discussion_answer')
                </div>
            </div>

        </div>
    </div>

@stop

@section('js')
    <script>
        $("#form-data").submit(function(e) {
            e.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');

            var file_data = new FormData();
            file_data.append('answer', $('#answer').val());

            r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
        });

        $("#btn_delete_discussion").click(function() {

            var url = "{{ $list_route['delete_discussion'] }}";

            var file_data = new FormData();

            r_action_table(file_data, "Apakah anda yakin ingin menghapus {{ $data['ctitle'] }} ini ?", url, 'redirect', null);
        });
    </script>
@stop