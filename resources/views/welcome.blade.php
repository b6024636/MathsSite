
@extends('layout')

@section('content')
    <div class="title m-b-md">Schools</div>
    <div class="links">
        <a href="{{ config('app.url')}}/schools/school/create">Create School</a>
        <a href="{{ config('app.url')}}/schools/school">View Schools</a>
    </div>
@endsection
