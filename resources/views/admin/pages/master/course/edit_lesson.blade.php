@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $data["csub_title"] = "Konten";
        $data["csub_sub_title"] = "Pelajaran";

        $list_route = array(
            "back" => $data["croute"] . 'edit_section/' . enc($results_data->course_section_id),
        );
    ?>

    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">{{ $data["csub_sub_title"] }}</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">
                            {{ $data["ctitle"] }}
                        </li>
                        <li class="breadcrumb-item">
                            {{ $data["csub_title"] }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $data["csub_sub_title"] }}
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <div class="page__container page-section">
        
        <form action="{{ $data['croute'] . 'update_lesson/' . enc($results_data->id) }}" id="form-data" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-md-8">

                <div class="page-separator">
                    <div class="page-separator__text">Informasi Dasar</div>
                </div>

                <div class="card">
                    <div class="card-body">
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
                                    <label class="form-label">Deskripsi</label>
                                    <div style="height: 300px;" name="description" id="description">
                                        <?= $results_data->description ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">

                                <div class="col-4">
                                    <label class="form-label" for="position">Urutan Ke <span class="text-danger">*</span> :</label>
                                    <input type="number" class="form-control" id="position" name="position" value="{{ $results_data->position }}" min="1">
                                </div>
                                
                                <div class="col-8">
                                    <label class="form-label" for="attachments">File :</label>

                                    @if (count($file_data) > 0)
                                        <br>
                                        <ul>

                                            @foreach ($file_data as $v)
                                                <?php $url = $data['files_course'] . $v->files . '.' . $v->extension; ?>
                                                <li>
                                                    <a class="text-primary mb-4" href="{{ $url }}" target="_blank">
                                                        {{ $v->files }}
                                                    </a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    @endif

                                    <div class="custom-file">
                                        <input type="file" id="attachments" name="attachments" class="custom-file-input" multiple="true">
                                        <label for="attachments" class="custom-file-label">Pilih file</label>
                                    </div>
                                    <small class="text-danger">*) Foto yang boleh di upload hanya pdf dengan maksimum file 2MB</small>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
        
                                <div class="col-4">
                                    <div class="custom-control custom-checkbox">
                                        <input id="can_preview" name="can_preview" type="checkbox" class="custom-control-input" {{ $results_data->can_preview == "1" ? 'checked' : '' }}>
                                        <label for="can_preview" class="custom-control-label">Bisa di Preview</label>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <a type="button" href="{{ $list_route['back'] }}" class="btn btn-outline-primary px-4">Kembali</a>
                                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            
            <div class="col-md-4">

                <div class="page-separator">
                    <div class="page-separator__text">Video {{ $data["csub_sub_title"] }}</div>
                </div>

                <div class="card">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" id="video_trailer" name="video_trailer" allowfullscreen=""></iframe>
                    </div>
                    <div class="card-body">
                        <label class="form-label">URL</label>
                        <input type="text" class="form-control" id="url_video" name="url_video" value="{{ $results_data->url_video }}" onchange="refresh_video()">
                    </div>
                </div>

            </div>
        </div>

        </form>

    </div>


@stop

@push('js')

@include('admin.pages.master.course.components.js_file')

<script>
    const description = new Quill('#description', {
        theme: 'snow'
    });

    $("#form-data").submit(function(e) {
		e.preventDefault();
		
		var form = $(this);
		var url = form.attr('action');

		var file_data = new FormData();
		file_data.append('title', $('#title').val());
		file_data.append('description', description.root.innerHTML);
		file_data.append('position', $('#position').val());
		file_data.append('can_preview', ($('#can_preview').prop('checked') ? 1 : 0));
		file_data.append('url_video', $('#url_video').val());
        
        var list_attachments = $("#attachments").get(0).files;

        for (let i = 0; i < list_attachments.length; i++) {
            file_data.append('attachments[]', list_attachments[i]);
        }

		r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'redirect', null);
	});
</script>
@endpush