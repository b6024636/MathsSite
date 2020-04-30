
@extends('layout')

@section('content')

    <h1>{{$data['code']['code']}} - {{$data['student']->student_id}}</h1>
    <hr/>
    <a href="{{url()->previous()}}">&laquo Back to group</a>
    <div class="card">
        <div class="card-body results-table">
            <div class="row">
                <div class="col-md-4">
                    <p class="font-weight-bold">Title</p>
                </div>
                <div class="col-md-2">
                    <p class="font-weight-bold">Status</p>
                </div>
                <div class="col-md-2">
                    <p class="font-weight-bold">Marks</p>
                </div>
                <div class="col-md-2">
                    <p class="font-weight-bold">Finished</p>
                </div>
                <div class="col-md-2">
                    <p class="font-weight-bold">No# of Attempts</p>
                </div>
            </div>
            @foreach($data['assigned_tasks'] as $assignedTasks)
                @if(!is_null($assignedTasks))
                    <div class="row result-row">
                        <div class="col-md-4">
                            {{$assignedTasks['assigned']->title}}
                        </div>
                        @if(isset($assignedTasks['completed']))
                            <div class="col-md-2">
                                <p>Completed</p>
                            </div>
                            <div class="col-md-2">
                                <p>{{$assignedTasks['completed']->total_marks_earned}} / {{$assignedTasks['assigned']->marks}}</p>
                            </div>
                            <div class="col-md-2">
                                <p>{{$assignedTasks['completed']->created_at}}</p>
                            </div>
                            <div class="col-md-2">
                                <p>{{$assignedTasks['completed']['attempts']}}</p>
                            </div>
                        @else
                            <div class="col-md-2">
                                <p>Incomplete</p>
                            </div>
                            <div class="col-md-2">
                                <p> 0 / {{$assignedTasks['assigned']->marks}}</p>
                            </div>
                            <div class="col-md-2">
                                <p>N/A</p>
                            </div>
                            <div class="col-md-2">
                                <p>0</p>
                            </div>
                        @endif

                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
