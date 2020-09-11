@extends('layouts.master')

@section('title', 'Admin Panel | Ledgr')

@section('content')
    <main class="page-container {{ auth::user()->theme }}">
        <div class="content-row">
            <div class="col-md-8">
                <h2>Admin Panel</h2>
            </div>
        </div>
        <div class="content-row">
            <div class="col-md-8">
                <button class="btn btn-outline-success btn-block"><a href="{{ route('archive') }}">Archive Tables</a></button>
            </div>
        </div>
    </main>
@endsection
