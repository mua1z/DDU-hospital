@extends('layouts.app')

@section('content')
<h1>Laboratory Dashboard</h1>
<p>Welcome, {{ auth()->user()->name }} ({{ auth()->user()->dduc_id }})</p>
@endsection
