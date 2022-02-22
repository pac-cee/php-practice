@extends('layouts.app')
@section('content')
<h2>Manage Users</h2>
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="background:#1A237E;color:#fff;">
            <th style="padding:0.5rem;">Name</th>
            <th style="padding:0.5rem;">Email</th>
            <th style="padding:0.5rem;">Role</th>
            <th style="padding:0.5rem;">School</th>
            <th style="padding:0.5rem;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr style="border-bottom:1px solid #eee;">
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
