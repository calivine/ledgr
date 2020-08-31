@extends('layouts.master')


@section('content')

<main class="container">
    <section class="confirm-delete">
        <p>Are you sure you want to delete this budget category?</p>

        <form action="{{ '/budget/' . $id . '/destroy' }}" method="POST">
            {{ method_field('delete') }}
            {{ csrf_field() }}
            <button class="btn btn-danger" type="submit">Delete</button>
        </form>
        <a href="{{ route('budget') }}">Cancel</a>
    </section>
</main>

@endsection
