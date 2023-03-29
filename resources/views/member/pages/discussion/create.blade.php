@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $list_route = array(
            'back' => route('member.course_member.index') . '/show/' . enc($results_data->course_id),
            "search_lesson" => $data["croute"] . "search_lesson/" . enc($results_data->id),
        );
    ?>

    @include('member.pages.course.components.show_top_nav')

    <div class="container page__container">
        <form id="form-data" action="{{ $data['croute'] . 'store/' . enc($results_data->id) }}">
            <div class="row">
                <div class="col">
                    <div class="page-section">
                        <h4>Berikan Pertanyaan</h4>

                        <div class="card o-hidden mb-0">

                            <div class="card-header">
                                <h5 class="m-0">Konten : {{ $results_data->course_section_title }}</h5>
                            </div>

                            <div class="card-body table--elevated">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label" for="lesson_id">Pelajaran :</label>
                                            <select name="lesson_id" id="lesson_id" class="form-control custom-select select2">
                                                <option value="{{ enc($results_data->id) }}" selected>{{ $results_data->title }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label" for="title">Judul :</label>
                                            <input type="text" class="form-control" id="title" name="title">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label" for="description">Deskripsi :</label>
                                            <textarea class="form-control" name="description" id="description" rows="6"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-accent">Kirim Pertanyaan</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>

@stop

@push('js')
    @include('member.pages.discussion.components.js_select2_lesson')

    <script>
        $("#form-data").submit(function(e) {
            e.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');

            var file_data = new FormData();
            file_data.append('lesson_id', $('#lesson_id').val());
            file_data.append('title', $('#title').val());
            file_data.append('description', $('#description').val());

            r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'redirect', null);
        });
    </script>
@endpush