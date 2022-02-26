@extends('layouts.app')
@section('content')
<h2>Available Quizzes for {{ $book->title }}</h2>
<ul style="list-style:none;padding:0;">
    @foreach($quizzes as $quiz)
    <li style="margin-bottom:1.2rem;">
        <div style="background:#f5f5f5;padding:1rem;border-radius:6px;">
            <strong>{{ $quiz->title }}</strong>
            <form method="POST" action="/quizzes/{{ $quiz->id }}/submit" style="margin-top:0.5rem;">
                @csrf
                <label for="score_{{ $quiz->id }}">Your Score (mock):</label>
                <input type="number" name="score" id="score_{{ $quiz->id }}" min="0" max="100" required style="width:80px;">
                <button class="btn" type="submit">Submit</button>
            </form>
        </div>
    </li>
    @endforeach
</ul>
@endsection
