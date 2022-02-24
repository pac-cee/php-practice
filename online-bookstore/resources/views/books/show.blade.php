@extends('layouts.app')
@section('content')
<div style="display:flex;gap:2rem;align-items:flex-start;">
    <img src="{{ $book->cover_image ?? '/img/default-cover.png' }}" alt="cover" style="height:180px;box-shadow:0 2px 8px #1A237E22;border-radius:6px;">
    <div>
        <h2>{{ $book->title }}</h2>
        <p><strong>Author:</strong> {{ $book->author->name ?? '' }}</p>
        <p><strong>Genre:</strong> {{ $book->genre }}</p>
        <p><strong>Format:</strong> {{ $book->format }}</p>
        <p><strong>Price:</strong> ${{ number_format($book->price, 2) }}</p>
        <p>{{ $book->description }}</p>
        @auth
            <form method="POST" action="/orders">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <input type="hidden" name="status" value="pending">
                <button class="btn" type="submit">Order Book</button>
            </form>
            <form method="POST" action="/user/wishlist" style="margin-top:0.5rem;">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <button class="btn" type="submit">Add to Wishlist</button>
            </form>
        @endauth
    </div>
</div>
@endsection
