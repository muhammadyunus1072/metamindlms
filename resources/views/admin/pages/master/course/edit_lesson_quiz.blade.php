@extends('admin.layouts.index')

@push('css')
    @livewireStyles
@endpush

@section('content')

    <?php
    $data['csub_title'] = 'Konten';
    $data['csub_sub_title'] = 'Pelajaran';
    
    $list_route = [
        'back' => $data['croute'] . 'edit_section/' . enc($results_data->course_section_id),
    ];
    ?>

    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">{{ $data['csub_sub_title'] }}</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">
                            {{ $data['ctitle'] }}
                        </li>
                        <li class="breadcrumb-item">
                            {{ $data['csub_title'] }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $data['csub_sub_title'] }}
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <div class="page__container page-section">
        @livewire('admin.lesson.edit-quiz', ['lesson' => $results_data])
    </div>
@stop

@push('js')
    @livewireScripts
@endpush
