
@extends('layout')

@section('content')

    <h1 class="font-weight-bold">{{$school->Name}}</h1>
    @auth('teacher')
        <p>Hello, {{$user->name}}</p>
        <div class="row">
            <div class="col-md-5 col-sm-12 mb-3">
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
                <div class="row mb-3">
                    <div class="card width-100">
                        <div class="card-header">
                            <p>Tasks</p>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <a href="/tasks/task/create" class="btn btn-blue">Create Task</a>
                            <a href="/myschool/task/manage" class="btn btn-blue">Manage Tasks</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-12">

            </div>
            <div class="col-md-5 col-sm-12">
                <div class="row mb-3">
                    <div class="card width-100">
                        <div class="card-header">
                            <p>Staff</p>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <a href="/register/teacher" class="btn btn-blue">Add Staff Member</a>
                            <a href="/manage/teachers" class="btn btn-blue">Manage Staff</a>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="card width-100">
                        <div class="card-header">
                            <p>Students</p>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <a href="/register/student" class="btn btn-blue">Add Student</a>
                            <a href="/manage/students" class="btn btn-blue">Manage Students</a>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="card width-100">
                        <div class="card-header">
                            <p>Add a new question</p>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <a href="/questions/question/create" class="btn btn-blue">Create question</a>
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
