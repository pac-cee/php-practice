@extends('layouts.app')
@section('content')
<h2>My Orders</h2>
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#1A237E;color:#fff;">
            <th style="padding:0.5rem;">Order ID</th>
            <th style="padding:0.5rem;">Book</th>
            <th style="padding:0.5rem;">Status</th>
            <th style="padding:0.5rem;">Date</th>
            <th style="padding:0.5rem;">Payment</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr style="border-bottom:1px solid #eee;">
            <td>{{ $order->id }}</td>
            <td>{{ $order->book->title ?? '' }}</td>
            <td>{{ ucfirst($order->status) }}</td>
