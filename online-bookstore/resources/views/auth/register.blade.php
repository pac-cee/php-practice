@extends('layouts.app')
@section('content')
<h2>Register</h2>
<form method="POST" action="/register">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required autofocus>
        @error('name')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        @error('email')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        @error('password')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>
    <button class="btn" type="submit">Register</button>
</form>
@endsection
