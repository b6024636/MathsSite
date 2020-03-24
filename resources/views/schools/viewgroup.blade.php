
@extends('layout')

@section('content')
    <h1>{{$group->code}}</h1>
    <a href="/myschool">&laquo Back to my school</a>
    <div class="row">
        <div class="col-md-12">
            @foreach($students as $student)
                <p>{{$student->student_id}}</p>
            @endforeach
        </div>
    </div>
@endsection
