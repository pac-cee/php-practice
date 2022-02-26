@extends('layouts.app')
@section('content')
<h2>My Profile</h2>
<form method="POST" action="/profile/update">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
        @error('name')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>
        @error('email')<div class="error">{{ $message }}</div>@enderror
    </div>
    <button class="btn" type="submit">Update Profile</button>
</form>
@endsection
