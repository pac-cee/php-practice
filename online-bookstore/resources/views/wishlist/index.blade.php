@extends('layouts.app')
@section('content')
<h2>My Wishlist</h2>
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#1A237E;color:#fff;">
            <th style="padding:0.5rem;">Cover</th>
            <th style="padding:0.5rem;">Title</th>
            <th style="padding:0.5rem;">Author</th>
            <th style="padding:0.5rem;">Remove</th>
        </tr>
    </thead>
    <tbody>
        @foreach($wishlist as $item)
        <tr style="border-bottom:1px solid #eee;">
            <td><img src="{{ $item->book->cover_image ?? '/img/default-cover.png' }}" alt="cover" style="height:60px;"></td>
            <td>{{ $item->book->title }}</td>
            <td>{{ $item->book->author->name ?? '' }}</td>
            <td>
