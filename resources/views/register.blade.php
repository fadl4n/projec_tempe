@extends('layouts.main')
@section('title', 'Register')

@section('content')
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-4">
    <main class="form-signin w-100 m-auto">
        <form method="POST" action="{{route('register.proses')}}">
        @csrf
          <h1 class="h3 mb-3 fw-normal">Please sign up</h1>

          <div class="form-floating my-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror"
            id="floatingName" name="name" placeholder="Full Name" value="{{ old('name') }}">
            <label for="floatingName">Full Name</label>
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-floating my-3">
            <input type="text" class="form-control @error('alamat') is-invalid @enderror"
            id="floatingName" name="alamat" placeholder="Full Name" value="{{ old('alamat') }}">
            <label for="floatingName">Alamat</label>
            @error('alamat')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-floating my-3">
            <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
            id="floatingName" name="no_telp" placeholder="Telepon" value="{{ old('no_telp') }}">
            <label for="floatingName">Telepon</label>
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-floating my-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror"
            id="floatingInput" name="email" placeholder="name@example.com" value="{{ old('email') }}">
            <label for="floatingInput">Email address</label>
            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-floating my-3">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
            <label for="floatingPassword">Password</label>
          </div>

          <div class="form-floating my-3">
            <input type="password" class="form-control" id="floatingConfirmPassword" name="password_confirmation" placeholder="Confirm Password">
            <label for="floatingConfirmPassword">Confirm Password</label>
          </div>
          <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              Remember me
            </label>
          </div>

          <button class="btn btn-primary w-100 py-2" type="submit">Sign up</button>

          <div class="text-center mt-3">
            <a href="/login" class="link-opacity-100 my-5">Already have an account? Sign in</a>
          </div>

        </form>
      </main>
    </div>
</div>
@endsection
