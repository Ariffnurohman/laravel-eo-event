@extends('layouts.auth')

@section('title', 'Login Admin')

@section('content')
<div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
    <h4 class="mb-3 text-center">🔐 Login Admin</h4>
    <form id="adminLoginForm">
        <div class="mb-3">
            <label>Email Admin</label>
            <input type="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" id="password" class="form-control" required>
        </div>
        <div id="alert" class="alert d-none mt-2"></div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>
@endsection