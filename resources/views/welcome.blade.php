
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     <!-- Bootstrap 5 CDN -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">To-Do App</a>
        </div>
        </nav>

<div class="container text-center mt-5">
    <h1 class="display-4 text-primary">Welcome to Our To-Do App</h1>
    <p class="lead">Stay organized and track your tasks efficiently.</p>

    @auth
        <div class="alert alert-success" role="alert">
            <strong>Hello, {{ auth()->user()->name }}!</strong> You are logged in.
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    @else
        <p class="mt-4">Please sign up or log in to continue.</p>
        <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-success">Sign Up</a>
    @endauth
</div>

</body>
</html>