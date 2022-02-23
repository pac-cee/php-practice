@extends('layouts.app')
@section('content')
<h2>Book Catalog</h2>
<form method="GET" action="/books" style="margin-bottom:1.5rem;display:flex;gap:1rem;">
    <input type="text" name="search" placeholder="Search title..." value="{{ request('search') }}">
    <select name="genre">
        <option value="">All Genres</option>
        {{-- Populate genres dynamically if available --}}
    </select>
    <button class="btn" type="submit">Search</button>
</form>
@if(session('message'))
    <div class="alert">{{ session('message') }}</div>
@endif
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#1A237E;color:#fff;">
            <th style="padding:0.5rem;">Cover</th>
            <th style="padding:0.5rem;">Title</th>
