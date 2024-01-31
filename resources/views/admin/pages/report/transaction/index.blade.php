@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')
    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">{{ $data["ctitle"] . ' ' . $data['title_transaction'] }}</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item">
                            {{ $data["ctitle"] }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $data["title_transaction"] }}
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <div class="page__container page-section">

        <div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<h4 class="card-title my-auto">List Data {{ $data["ctitle"] . ' ' . $data['title_transaction'] }}</h4>
				</div>
			</div>
			<div class="card-body">
				@livewire('admin.report.transaction.filter')
				@livewire('admin.report.transaction.datatable')

				
			</div>
		</div>

    </div>

    <!-- // END Page Content -->

@stop

