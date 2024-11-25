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
                <form method="POST" action="{{ route('forget.password.post') }}">
                    @csrf
                    <h1 class="h3 mb-3 fw-normal">Masukkan email kamu yang sudah terdaftar</h1>

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





                    <button class="btn btn-primary w-100 py-2" type="submit">Submit</button>


                </form>
            </main>
        </div>
    </div>
@endsection
