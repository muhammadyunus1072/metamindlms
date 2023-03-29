@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $list_route = array(
            'back' => route('member.course_member.index') . '/show/' . enc($results_data->course_id),
        );
    ?>

    @include('member.pages.course.components.show_top_nav')

    <div class="container page__container">
        <div class="page-section">

            <div class="row">
                <div class="col">

                    <form id="form-data" action="{{ $data['croute'] . 'update/' . enc($results_data->id) }}">
                        <div class="row">
                            <div class="col">
                                <div class="page-section">
            
                                    <div class="card o-hidden mb-0">
            
                                        <div class="card-header">
                                            <h5 class="m-0">Konten : {{ $results_data->course_section_title }}</h5>
                                        </div>
            
                                        <div class="card-body table--elevated">
            
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label" for="lesson_id">Pelajaran :</label>
                                                        <p class="m-0">{{ $results_data->lesson_title }}</p>
                                                    </div>
                                                </div>
                                            </div>
            
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label" for="title">Judul :</label>
                                                        <input type="text" class="form-control" id="title" name="title" value="{{ $results_data->title }}">
                                                    </div>
                                                </div>
                                            </div>
            
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label" for="description">Deskripsi :</label>
                                                        <textarea class="form-control" name="description" id="description" rows="6"><?= $results_data->description ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-accent">Simpan</button>
                                        </div>
            
                                    </div>
            
                                </div>
                            </div>
                        </div>
                    </form>

                    @include('member.pages.discussion.components.detail_discussion_answer')
                </div>
            </div>

        </div>
    </div>

@stop

@push('js')
    <script>
        $("#form-data").submit(function(e) {
            e.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');

            var file_data = new FormData();
            file_data.append('title', $('#title').val());
            file_data.append('description', $('#description').val());

            r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
        });
    </script>
@endpush