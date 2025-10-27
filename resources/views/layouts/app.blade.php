<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

</head>
<body class="bg-white">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">To-Do List</a>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Oops! Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <footer class="text-center text-muted mt-5">
        <p>&copy; {{ date('Y') }} - Kifansa</p>
    </footer>
</body>
</html>
