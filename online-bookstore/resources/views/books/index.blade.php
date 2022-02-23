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
            <th style="padding:0.5rem;">Author</th>
            <th style="padding:0.5rem;">Genre</th>
            <th style="padding:0.5rem;">Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr style="border-bottom:1px solid #eee;">
            <td><img src="{{ $book->cover_image ?? '/img/default-cover.png' }}" alt="cover" style="height:60px;"></td>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author->name ?? '' }}</td>
            <td>{{ $book->genre }}</td>
            <td>${{ number_format($book->price, 2) }}</td>
            <td><a href="/books/{{ $book->id }}" class="btn">View</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
<div style="margin-top:1.5rem;">
    {{ $books->links() }}
</div>
@endsection
