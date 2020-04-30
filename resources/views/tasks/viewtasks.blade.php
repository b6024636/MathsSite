
@extends('layout')

@section('content')

    @if($tasks == '')
        <h2 class="mb-4 mt-2"><strong>Pick a topic...</strong></h2>
        <div class="pt-md-4 col-md-12">
            <div class="row justify-content-center">
                <?php $count = 0 ?>
                @foreach($topics as $topic)
                    <div class="col-md-3 topic-col">
                        <a href="/tasks/task?topic={{$topic->id}}" class="task-button d-flex flex-column justify-content-center align-text-center">
                            <i class="fas fa-{{$topic->icon}} task-icon font ease-in-out"></i>{{$topic->title}}
                            <i class="far fa-arrow-alt-circle-right hide task-arrow"></i></a>
                    </div>
                    <?php $count++ ?>
                    @if($count % 4 == 0)
            </div>
            <div class="row justify-content-center">
                @endif
                @endforeach
            </div>
        </div>
    @else
        <h1>{{$chosenTopic}} tasks</h1>
        <a href="/tasks/task">Back to tasks</a>
        <div class="card">
            <div class=" col-md-12 table card-body task-table">
                <div class="row mb-2">
                    <div class="col-md-3 col-sm-1">
                        <strong>Title</strong>
                    </div>
                    <div class="col-md-3 col-sm-1 mobile-hide">
                        <strong>Marks Available</strong>
                    </div>
                    <div class="col-md-3 col-sm-1 mobile-hide">
                        <strong>Rating</strong>
                    </div>
                    <div class="col-md-3 col-sm-1">
                    </div>
                </div>

                {{--            @if(count($tasks) > 0)--}}
                @foreach ($tasks as $task)
                    <div class="row task-row d-flex justify-content-between pt-1 pb-1">
                        <div class="col-md-3 task-title pt-2">{{ $task->title }}</div>
                        <div class="col-md-3 col-sm-1 mobile-hide pt-2">{{ $task->marks }}</div>
                        <div class="col-md-3 col-sm-1 mobile-hide pt-2">{{ $task->rating }}</div>
                        <div class="col-md-3"><a href="/tasks/task/begintask/{{$task->id}}" class="btn btn-primary btn-sm mobile-btn">Attempt task</a></div>
                    </div>
                @endforeach
                {{--                            @endif--}}
            </div>
        </div>

    @endif
@endsection
