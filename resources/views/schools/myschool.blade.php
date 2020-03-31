
@extends('layout')

@section('content')

    <h1>{{$school->Name}}</h1>
    @auth('teacher')
        <p>Hello, {{$user->name}}</p>
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row d-flex flex-column card mb-2">
                    <div class="card-header">
                        <a id="create-group-btn" class="text" href="#">Create a new group</a>
                    </div>
                    <div id="create-group-container" class="create-group-container hide card-body">
                        {{ HTML::ul($errors->all()) }}
                        {{ Form::open(array('url' => 'groups/group')) }}
                        <label for="group-code">Group Code</label>
                        <div class="row">
                            <div class="col-md-8 code">
                                <input type="text" id="group-code" name="code"/>
                            </div>
                            <div class="col-md-4 form-submit">
                                {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
                            </div>
                        </div>
                        {{ Form::close()  }}
                    </div>
                </div>
                <div class="row d-flex flex-column card mb-2">
                    <div class="card-header">
                        <p>Our Groups</p>
                    </div>
                    <div class="row d-flex justify-content-center card-body">
                        <div id="view-group-container" class="view-group-container col-md-12">
                            @foreach($groups as $group)
                                <div class="row ">
                                    <div class="col-md-7">
                                        <span>
                                            {{$group->code}}
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="/groups/group/{{$group->id}}">View</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#create-group-btn').click(function(){
                event.preventDefault();
                $('#create-group-container').removeClass('hide');
            });
        </script>
    @endauth
    @auth('student')
        <p>Hello, {{$user->student_id}}</p>
        <div id="view-group-container" class="card">
            <div class="card-header">
                <h3>My Work</h3>
            </div>
            <div class="card-body view-group-container">
                @foreach($tasks as $task)
                    <div class="row ">
                        <div class="col-md-7">
                        <span>
                           {{$task->title}}
                        </span>
                        </div>
                        <div class="col-md-5">
                            <a href="/tasks/task/begintask/{{$task->id}}">Attempt task</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endauth
@endsection
