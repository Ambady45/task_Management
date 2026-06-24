<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ route('tasks.index') }}">
            Task Management
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="btn btn-danger">
                Logout
            </button>
        </form>

    </div>
</nav>

<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')

</div>

</body>
</html>