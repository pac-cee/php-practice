@extends('layouts.app')
@section('content')
<h2>Login</h2>
<form method="POST" action="/login">
    @csrf
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required autofocus>
        @error('email')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        @error('password')<div class="error">{{ $message }}</div>@enderror
    </div>
    <button class="btn" type="submit">Login</button>
    <a href="/password/reset" style="margin-left:1rem;">Forgot Password?</a>
</form>
@endsection
