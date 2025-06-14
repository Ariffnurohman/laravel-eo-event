@extends('layouts.guest')

@section('content')
<div class="container mt-5">
    @if(session('error'))
    @endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 text-center">
                    <h4 class="mb-0">Login</h4>
                </div>

                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email">Email:</label>
                            <input id="email" type="email" class="form-control" name="email" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password">Password:</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success">Masuk</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection