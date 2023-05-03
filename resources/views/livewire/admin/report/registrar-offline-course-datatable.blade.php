{{-- Data Table --}}
@extends('livewire.livewire-datatable')

@section('top_content')
    <div class="row mb-2 mt-2">
        <a href="#" class="btn btn-success ml-2" wire:click.prevent='export'>
            <i class="fa fa-file-excel mr-2"></i>
            Export Excel
        </a>
    </div>
@endsection
