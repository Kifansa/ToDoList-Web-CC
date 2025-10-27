@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                <h5 class="mb-0">Tambah Tugas Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @include('tasks._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
