
@extends('layout')

@section('content')
    <div class="title m-b-md">Schools</div>
    <div class="links">
        <a href="{{ config('app.url')}}/schooltest/create">Create School</a>
        <a href="{{ config('app.url')}}/schooltest">View School</a>
    </div>
@endsection
