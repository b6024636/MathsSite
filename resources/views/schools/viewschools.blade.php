
@extends('layout')

@section('content')

<h1>Here's a list of schools</h1>
<table class="table">
    <thead>
    <td>Name</td>
    <td>Contact</td>
    <td>Email</td>
    <td>Pending?</td>
    <td>Logo</td>
    <td></td>
    </thead>
    <tbody>
    @foreach ($allSchools as $school)

        <tr>
            <td>{{ $school->Name }}</td>
            <td class="inner-table">{{ $school->Contact_Number }}</td>
            <td class="inner-table">{{ $school->Email }}</td>
            <td class="inner-table">{{($school->Pending) ? 'True' : 'False'}}</td>
            <td class="inner-table">{{$school->Logo}}</td>
            <td class="inner-table"><a href="/admin/school/{{$school->id}}">View School</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<a href="{{ config('app.url')}}/schools/school/create">Add School</a>
@endsection
