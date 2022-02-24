@extends('layouts.app')
@section('content')
<h2>Dashboard</h2>
@if(Auth::user()->role === 'admin')
    <div style="margin-bottom:2rem;">
        <h3>Admin Panel</h3>
        <a href="/admin/reports" class="btn">View Reports</a>
        <a href="/admin/users" class="btn">Manage Users</a>
        <a href="/admin/books" class="btn">Manage Books</a>
    </div>
@endif
<div style="margin-bottom:2rem;">
    <h3>My Orders</h3>
    {{-- Orders table/list will be rendered here --}}
</div>
<div style="margin-bottom:2rem;">
    <h3>My Wishlist</h3>
    {{-- Wishlist table/list will be rendered here --}}
</div>
<div style="margin-bottom:2rem;">
    <h3>My Quiz Results</h3>
    {{-- Quiz results table/list will be rendered here --}}
</div>
@endsection
