@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $list_route = array(
            "search_level" => $data["croute"] . "search_level",
            "search_category" => $data["croute"] . "search_category",
            "store_section" => $data["croute"] . "store_section/" . enc($results_data->id),
            "edit_section" => $data["croute"] . "edit_section/",
            "update_section" => $data["croute"] . "update_section/",
            "destroy_section" => $data["croute"] . "destroy_section/", 
            "edit_lesson" => $data["croute"] . "edit_lesson/", 
            "store_learn_description" => $data["croute"] . "store_learn_description/". enc($results_data->id), 
            "edit_learn_description" => $data["croute"] . "edit_learn_description/", 
            "update_learn_description" => $data["croute"] . "update_learn_description/", 
            "destroy_learn_description" => $data["croute"] . "destroy_learn_description/", 
            "store_lesson" => $data["croute"] . "store_lesson/",
        );
    ?>

    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">{{ $data['ctitle'] }}</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">
                            {{ $data['ctitle'] }}
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <div class="page__container page-section">
        
        <form action="{{ $data['croute'] . 'update/' . enc($results_data->id) }}" id="form-data" method="POST" enctype="multipart/form-data">
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
                                <div class="col-6">
                                    <label class="form-label" for="title">Judul :</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $results_data->title }}">
                                </div>
        
                                <div class="col-6">
                                    <label class="form-label" for="about">Tentang :</label>
                                    <textarea class="form-control" name="about" id="about" rows="6">{{ $results_data->about }}</textarea>
                                </div>
                            </div>
                        </div>
        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label" for="description">Deskripsi :</label>
                                    <textarea class="form-control" name="description" id="description" rows="6">{{ $results_data->description }}</textarea>
                                </div>
                            </div>
                        </div>
        
                        <div class="form-group">
                            <div class="row">
                                
                                <div class="col-6">
                                    <label class="form-label" for="url_image">Foto :</label>
                                    @if ($results_data->url_image)
                                        <?php $url = $data['files_course'] . $results_data->url_image; ?>
                                        <br>
                                        <a class="text-primary mb-4" href="{{ $url }}" target="_blank">
                                            {{ $results_data->url_image }}
                                        </a>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" id="url_image" name="url_image" class="custom-file-input">
                                        <label for="url_image" class="custom-file-label">Pilih file</label>
                                    </div>
                                    <small class="text-danger">*) Foto yang boleh di upload hanya jpg dan png dengan maksimum file 2MB</small>
                                </div>
        
                                
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button type="button" onclick="history.back();" class="btn btn-outline-primary px-4">Kembali</button>
                                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="page-separator">
                            <div class="page-separator__text">Konten Kursus</div>
                        </div>
                    </div>
    
                    <div class="col-auto">
                        <button type="button" id="btn_add_section" name="btn_add_section" class="btn btn-info btn-sm"
                            data-target="#add_section_modal" data-toggle="modal">
                            <span class="fas fa-plus mr-2"></span> Tambah Konten
                        </button>
                    </div>
                </div>

                @if (count($section_data) > 0)
                    <div class="row">
                        <div class="col">
        
                            <div class="accordion js-accordion accordion--boxed list-group-flush"
                                    id="parent">
        
                                @foreach ($section_data as $k=>$v)
                                    <?php $index = $k+1; ?>
                                    <div class="accordion__item">
                                        <a href="#"
                                            class="accordion__toggle collapsed"
                                            data-toggle="collapse"
                                            data-target="#course-toc-{{ $index }}"
                                            data-parent="#parent">
                                            <span class="flex {{ $v->is_actived ? '' : 'text-muted' }}">{{ $index.'. '.$v->title }}
                                                <span onclick="add_lesson('{{ enc($v->id) }}')"><i class="fas fa-plus text-secondary ml-2"></i></span>

                                                <span onclick="edit_section('{{ enc($v->id) }}')"><i class="fas fa-pen text-secondary ml-2"></i></span>
                                                <span onclick="destroy_section('{{ enc($v->id) }}')"><i class="fas fa-trash text-secondary ml-2"></i></span>
                                            </span>
                                            
                                            <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                                        </a>
                                        <div class="accordion__menu collapse" id="course-toc-{{ $index }}">

                                            @foreach ($v->lesson as $y)
                                                <div class="accordion__menu-link">
                                                    <span class="icon-holder icon-holder--small icon-holder--primary rounded-circle d-inline-flex icon--left">
                                                        <i class="material-icons icon-16pt">play_circle_outline</i>
                                                    </span>
                                                    <a class="flex" href="{{ $list_route['edit_lesson'] . enc($y->id) }}">{{ $y->title }}</a>
                                                    @if ($y->is_actived)
                                                        <span class="badge badge-info">Aktif</span>
                                                    @else
                                                        <span class="badge badge-danger">Tidak Aktif</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
        
                        </div>
                    </div>
                @else
                    <p>Belum ada konten kursus.</p>
                @endif

            </div>

            
            <div class="col-md-4">

                <div class="page-separator">
                    <div class="page-separator__text">Kursus</div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Kategori</label>
                                    <select name="category_id" id="category_id" class="form-control custom-select select2" multiple="multiple">
                                        @foreach ($category_data as $v)
                                            <option value="{{ $v->category_code }}" selected>{{ $v->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Level</label>
                                    <select name="level_id" id="level_id" class="form-control custom-select select2">
                                        <option value="{{ enc($results_data->level_id) }}" selected>{{ $results_data->level_name }}</option>
                                    </select>
                                </div>
    
                                <div class="col-md-6">
                                    <label class="form-label">Harga</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group form-inline">
                                                <span class="input-group-prepend"><span class="input-group-text">Rp</span></span>
                                                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $results_data->price }}" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="page-separator">
                    <div class="page-separator__text">Video Trailer</div>
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

                <div class="row">
                    <div class="col">
                        <div class="page-separator">
                            <div class="page-separator__text">Poin Pembelajaran</div>
                        </div>
                    </div>
    
                    <div class="col-auto">
                        <button type="button" id="btn_add_learning_description" name="btn_add_learning_description" class="btn btn-info btn-sm"
                            data-target="#add_learn_description_modal" data-toggle="modal">
                            <span class="fas fa-plus mr-2"></span> Tambah
                        </button>
                    </div>
                </div>

                <ul class="list-unstyled">
                    @if (count($learn_description_data) > 0)
                        @foreach ($learn_description_data as $v)
                            <li class="d-flex align-items-top">
                                <span class="material-icons text-50 mr-8pt" onclick="edit_learn_description('{{ enc($v->id) }}')">mode_edit</span>
                                <span class="text-70">{{ $v->description }}</span>
                            </li>
                        @endforeach
                    @else
                        <p>Belum ada poin pembelajaran.</p>
                    @endif
                    
                </ul>

            </div>
        </div>

        </form>

    </div>


@stop

@section('modal')
    @include('admin.pages.master.course.components.modal_add_lesson')

    @include('admin.pages.master.course.components.modal_add_section')

    @include('admin.pages.master.course.components.modal_add_learn_description')
    @include('admin.pages.master.course.components.modal_edit_learn_description')
@endsection

@push('js')

@include('admin.pages.master.course.components.js_file')

@include('admin.pages.master.course.components.js_select2')

<script>
    $("#form-data").submit(function(e) {
		e.preventDefault();
		
		var form = $(this);
		var url = form.attr('action');

		var file_data = new FormData();
		file_data.append('title', $('#title').val());
		file_data.append('about', $('#about').val());
		file_data.append('description', $('#description').val());
		file_data.append('level_id', $('#level_id').val());
		file_data.append('price', $('#price').val());
		file_data.append('url_video', $('#url_video').val());
        file_data.append('url_image', $("#url_image").get(0).files[0]); 

        var list_category = $('#category_id').select2('data');

        for (let i = 0; i < list_category.length; i++) {
            file_data.append('category_id[]', list_category[i].id);
        }

        console.log(list_category);

		r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'redirect', null);
	});
</script>

<script>
    function add_lesson(id){
        $('#add_lesson_section_id').val(id);
        $('#add_lesson_modal').modal('show');
    }

    $("#btn_store_lesson").click(function() {
        var id = $('#add_lesson_section_id').val();
        var url = "{{ $list_route['store_lesson'] }}" + id;

		var file_data = new FormData();
		file_data.append('title', $('#add_lesson_title').val());
		file_data.append('position', $('#add_lesson_position').val());
		file_data.append('type', $('#add_lesson_type').val());

		r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
    });
</script>



<script>
    $("#btn_store_learn_description").click(function() {

        var url = "{{ $list_route['store_learn_description'] }}";

		var file_data = new FormData();
		file_data.append('description', $('#add_learn_description_description').val());

		r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
    });

    function edit_learn_description(id){
        loading("show")

        var url = "{{ $list_route['edit_learn_description'] }}" + id;

        var file_data = new FormData();
        
        $.ajax({
            url: url,
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: file_data,
            success: function(result) {
                loading('hide')

                if (result['st'] == 's') {
                    var results_data = result['results_data'];

                    $('#edit_learn_description_id').val(results_data['enc']);
                    $('#edit_learn_description_description').val(results_data['description']);
                    $('#edit_learn_description_modal').modal('show');

                } else info_server('error', result['s']);
            },
            error: function(xhr, res, result) {
                loading('hide')
                alert_error("show", xhr);
            }
        });
    }

    $("#btn_update_learn_description").click(function() {
        var id = $('#edit_learn_description_id').val();
        var url = "{{ $list_route['update_learn_description'] }}" + id;

		var file_data = new FormData();
		file_data.append('description', $('#edit_learn_description_description').val());

		r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
    });

    $("#btn_delete_learn_description").click(function() {
        var id = $('#edit_learn_description_id').val();
        var url = "{{ $list_route['destroy_learn_description'] }}" + id;

		var file_data = new FormData();

		r_action_table(file_data, "Apakah anda yakin ingin menghapus poin pembelajaran ini ?", url, 'page', null);
    });
</script>

<script>
    $("#btn_store_section").click(function() {

        var url = "{{ $list_route['store_section'] }}";

		var file_data = new FormData();
		file_data.append('title', $('#add_section_title').val());
		file_data.append('position', $('#add_section_position').val());
		file_data.append('is_actived', $('#add_section_is_actived').val());

		r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
    });



    function edit_section(id){
        window.location.assign("{{ $list_route['edit_section'] }}" + id);
    }
</script>

@include('admin.pages.master.course.components.js_destroy_section')
    
@endpush