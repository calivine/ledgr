@extends('layouts.master')

@section('title', 'Error: ' . $status_code)

@section('content')

<section>
	<h2>{{ $status_code }}</h2>
	<p>Something went wrong...</p>

@endsection