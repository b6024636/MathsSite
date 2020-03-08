
@extends('layout')

@section('content')

    <h1>{{$school['Name']}}</h1>
    <div class="container-fluid">
        <div class="col-md-12">
            @foreach($school as $key => $value)

                <div class="row">
                    <div class="col-md-6 font-weight-bold">
                        <span>{{$key}}:</span>
                    </div>
                    <div class="col-md-6 ">
                        <span>{{$value}}</span>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <a href="/schools/school">Back to list</a>
        </div>
        <div class="col-md-6">
            <a href="/schools/school">Edit</a>
        </div>
    </div>
@endsection
