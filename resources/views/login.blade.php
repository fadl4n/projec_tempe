@extends('layouts.main')
@section('title', 'Login')

@section('content')
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <main class="form-signin w-100 m-auto">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form method="POST" action="{{ route('login.action') }}">
                    @csrf
                    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                    <div class="form-floating my-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="floatingInput" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                        <label for="floatingInput">Email address</label>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-floating my-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="floatingPassword" name="password" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between my-3">
                        <div>
                            <input class="form-check-input" type="checkbox" name="remember-me" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Remember me
                            </label>
                        </div>
                        <div>
                            <a href="{{ route('forget.password.get') }}" class="link-opacity-100">Forgot Password?</a>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>

                    <div class="text-center mt-3">
                        Don`t Have Account?
                        <a href="/register" class="link-opacity-100 my-5"> Sign Up</a>
                    </div>
                </form>
            </main>
        </div>
    </div>
@endsection
