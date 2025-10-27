@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Tugas</h5>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                        + Tambah Tugas Baru
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                            <tr>
                                    <th scope="col" style="width: 5%;">#</th>
                                    <th scope="col" style="width: 25%;">Judul</th>
                                    <th scope="col" style="width: 35%;">Deskripsi</th>
                                    <th scope="col" style="width: 15%;">Status</th>
                                    <th scope="col" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->description ?? '-' }}</td>

                                        <td>
                                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="form-check form-switch m-0 p-0">
                                                @csrf
                                                @method('PATCH')
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       role="switch"
                                                       name="completed"
                                                       value="1"
                                                       id="task-{{ $task->id }}"
                                                       @checked($task->completed)
                                                       onchange="this.form.submit()">
                                                <label class="form-check-label ps-2" for="task-{{ $task->id }}">
                                                    {{ $task->completed ? 'Selesai' : 'Belum' }}
                                                </label>
                                            </form>
                                        </td>

                                        <td>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Data tugas masih kosong.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
