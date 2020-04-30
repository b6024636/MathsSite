
@extends('layout')

@section('content')
    <h2>Manage Tasks</h2>
    <a href="/myschool" class="pt-4 mb-3">Back to my school</a>
    <div class="card mt-3">
        <div class=" col-md-12 table card-body task-table">
            <div class="row mb-2">
                <div class="col-md-3 col-sm-1">
                    <strong>Title</strong>
                </div>
                <div class="col-md-3 col-sm-1 mobile-hide">
                    <strong>Marks Available</strong>
                </div>
                <div class="col-md-3 col-sm-1">
                </div>
                <div class="col-md-3 col-sm-1">
                </div>
            </div>

            {{--            @if(count($tasks) > 0)--}}
            @foreach ($tasks as $task)
                <div class="row task-row d-flex justify-content-between pt-1 pb-1">
                    <div class="col-md-3 task-title pt-2">{{ $task->title }}</div>
                    <div class="col-md-3 col-sm-1 mobile-hide pt-2">{{ $task->marks }}</div>
                    <div class="col-md-3">
                        {{Form::open(['method' => 'GET', 'route' => ['task.edit', $task->id] ])}}
                        {{--                            {{ Form::hidden('id', $task->id) }}--}}
                        {{ Form::submit('Edit', ['class' => 'btn btn-primary btn-sm mobile-btn']) }}
                        {{Form::close()}}
                    </div>
                    <div class="col-md-3">
                        {{Form::open(['method' => 'DELETE', 'url' => 'tasks/task/' . $task->id])}}
                        {{ Form::hidden('id', $task->id) }}
                        {{ Form::submit('Delete', ['class' => 'btn btn-danger btn-sm mobile-btn']) }}
                        {{Form::close()}}
                    </div>
                </div>
            @endforeach
            {{--                            @endif--}}
        </div>
    </div>
@endsection
