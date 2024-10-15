@extends('layouts.app')

@section('container')
<section class="container d-flex justify-content-center align-items-center flex-column" style="height: 100vh">
    <h1>Sign In</h1>

    @if (session()->has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Login -->
    <form action="{{ route('login.post') }}" method="POST" class="w-100" style="max-width: 400px;">
        @csrf
        <!-- Input untuk Username -->
        <div class="mb-3 mt-3">
            <label for="username" class="form-label">Username</label>
            <input
                type="text"
                name="username"
                class="form-control @error('username') is-invalid @enderror"
                id="username"
                placeholder="Masukkan Username"
                value="{{ old('username') }}"
                required
            >
            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Input untuk Password -->
        <div class="mb-3 mt-3">
            <label for="password" class="form-label">Password</label>
            <input
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                id="password"
                placeholder="Masukkan Password"
                required
            >
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <p>Click here for <a href="{{ route('register') }}">Sign Up</a></p>

        <button type="submit" class="btn btn-primary w-100 mt-3">
            Login
        </button>
    </form>
</section>
@endsection
