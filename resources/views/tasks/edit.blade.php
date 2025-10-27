@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                <h5 class="mb-0">Edit Tugas: {{ $task->title }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @method('PUT')
                        @include('tasks._form', ['task' => $task])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
