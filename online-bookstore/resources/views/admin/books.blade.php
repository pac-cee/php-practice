@extends('layouts.app')
@section('content')
<h2>Manage Books</h2>
<a href="/admin/books/create" class="btn" style="margin-bottom:1rem;">Add New Book</a>
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#1A237E;color:#fff;">
            <th style="padding:0.5rem;">Title</th>
            <th style="padding:0.5rem;">Author</th>
            <th style="padding:0.5rem;">Genre</th>
            <th style="padding:0.5rem;">Price</th>
            <th style="padding:0.5rem;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr style="border-bottom:1px solid #eee;">
            <td>{{ $book->title }}</td>
            <td>{{ $book->author->name ?? '' }}</td>
            <td>{{ $book->genre }}</td>
            <td>${{ number_format($book->price, 2) }}</td>
            <td>
                <a href="/admin/books/{{ $book->id }}/edit" class="btn">Edit</a>
                <form action="/admin/books/{{ $book->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn" type="submit" onclick="return confirm('Delete this book?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
