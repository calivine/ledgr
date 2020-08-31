@extends('layouts.master')


@section('content')

<main class="container">
    <section class="confirm-delete">
        <p>Are you sure you want to delete this transaction?</p>

        <form action="{{ '/transaction/' . $id . '/destroy' }}" method="POST">
            {{ method_field('delete') }}
            {{ csrf_field() }}
            <button class="btn btn-danger" type="submit">Delete</button>
        </form>
        <a href="{{ route('dashboard') }}">Cancel</a>
    </section>
</main>

@endsection
