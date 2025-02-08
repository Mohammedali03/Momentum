@extends('components.template')

@section('content')
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
@endsection
