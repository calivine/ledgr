@extends('layouts.master')

@section('title', 'Admin Panel | Ledgr')

@section('content')
    <main class="page-container {{ auth::user()->theme }}">
        <div class="content-row">
            <div class="col-md-8">
                <h2>Admin Panel</h2>
            </div>
        </div>
        <div class="content-row my-2">
            <div class="col-md-8">
                <button class="btn btn-success btn-block"><a href="{{ route('archive') }}">Archive Tables</a></button>
            </div>
        </div>
        <div class="content-row my-2">
            <div class="col-md-8">
                <button class="btn btn-success btn-block"><a href="{{ route('readArchive') }}">Decrypt Archives</a></button>
            </div>
        </div>
    </main>
@endsection
