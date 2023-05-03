{{-- DataTable --}}
@extends('livewire.livewire-datatable')

@section('top_content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Jumlah Pendaftar</h5>
                </div>
                <div class="card-body">
                    <h4 class="text-center">{{ $total_offline_course_registrar }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Jumlah Kehadiran</h5>
                </div>
                <div class="card-body">
                    <h4 class="text-center">{{ $total_offline_course_attendance }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-2 mt-2">
        <a href="#" class="btn btn-success ml-2" wire:click.prevent='export'>
            <i class="fa fa-file-excel mr-2"></i>
            Export Excel
        </a>
    </div>
@endsection
