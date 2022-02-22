@extends('layouts.app')
@section('content')
<h2>Analytics Reports</h2>
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#1A237E;color:#fff;">
            <th style="padding:0.5rem;">Type</th>
            <th style="padding:0.5rem;">School</th>
            <th style="padding:0.5rem;">Generated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $report)
        <tr style="border-bottom:1px solid #eee;">
            <td>{{ $report->type }}</td>
            <td>{{ $report->school->name ?? '' }}</td>
            <td>{{ $report->generated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
