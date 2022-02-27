@extends('layouts.app')
@section('content')
<h2>My Quiz Results</h2>
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#1A237E;color:#fff;">
            <th style="padding:0.5rem;">Quiz</th>
            <th style="padding:0.5rem;">Book</th>
            <th style="padding:0.5rem;">Score</th>
            <th style="padding:0.5rem;">Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
        <tr style="border-bottom:1px solid #eee;">
            <td>{{ $result->quiz->title ?? '' }}</td>
            <td>{{ $result->quiz->book->title ?? '' }}</td>
            <td>{{ $result->score }}</td>
            <td>{{ $result->date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
