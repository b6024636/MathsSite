
@extends('layout')

@section('content')

    <h1>{{$school->Name}}</h1>
    @auth('teacher')
        <p>Hello, {{$user->name}}</p>
    @endauth
    @auth('student')
        <p>Hello, {{$user->student_id}}</p>
    @endauth
@endsection
