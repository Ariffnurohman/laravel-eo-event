@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<div class="container">
    <h4 class="mb-4">👤 Profil Admin</h4>
    
    <div class="card shadow-sm p-4">
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role ?? 'admin') }}</p>
    </div>
</div>
@endsection