
@extends('layout')

@section('content')
<h1>Here's a list of schools</h1>
<table class="table">
    <thead>
    <td>Name</td>
    <td>Description</td>
    <td>Count</td>
    <td>Price</td>
    </thead>
    <tbody>
    @foreach ($allSchools as $school)
        <tr>
            <td class="sr-only">{{$school->id}}</td>
            <td>{{ $school->name }}</td>
            <td class="inner-table">{{ $school->address }}</td>
            <td class="inner-table">{{ $school->contact }}</td>
            <td class="inner-table">{{ $school->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
