@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <div class="pt-32pt">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Forum Diskusi</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>

                        <li class="breadcrumb-item active">

                            Forum Diskusi

                        </li>

                    </ol>

                </div>
            </div>

        </div>
    </div>

    <div class="container page__container">
        <div class="page-section">

            <div class="page-separator">
                <div class="page-separator__text">Forum Diskusi</div>
            </div>

            <div class="card">

                <div class="list-group list-group-flush">

                    @foreach ($results_data as $v)
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


                    {{ $results_data->links('pagination.pagination') }}

                </div>
            </div>
        </div>
    </div>

@stop

@push('js')
@endpush