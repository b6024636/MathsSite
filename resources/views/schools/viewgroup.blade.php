
@extends('layout')

@section('content')
    <h1>{{$group->code}}</h1>
    <a href="/myschool">&laquo Back to my school</a>
    <div class="row mb-4">
        <div class="col-md-5 col-sm-12 card">
            <div class="row p-2 card-header">
                <h2>Group Members</h2>
            </div>
            <div class="card-body-tm">
                @if(count($students) == 0)
                    <div class="row p-2">
                        <p>N/A</p>
                    </div>
                @else
                    @foreach($students as $student)
                        <div class="row p-2">
                            <div class="col-md-6">
                                <p>{{$student->student_id}}</p>
                            </div>
                            <div class="col-md-3">
                                <a href="#">Check work</a>
                            </div>
                            <div class="col-md-3">
                                {{ Form::open(array('url' => 'groups/removeuser')) }}
                                <input name="group_id" type="hidden" value="{{$group->id}}">
                                <input name="user" type="hidden" value="student">
                                <input name="student_id" type="hidden" value="{{$student->id}}">
                                {{ Form::submit('Remove', array('class' => 'btn btn-link p-0 width-100')) }}
                                {{ Form::close()  }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-1 mb-2">

        </div>
        <div class="col-md-6 col-sm-12">
            <div class="row mb-3">
                <div class="col-md-12 card">
                    <div class="row card-header">
                        <h2>Set Work</h2>
                    </div>
                    <div class="row p-2">
                        <a href="#">Example</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 card">
                    <div class="row card-header d-flex justify-content-between">
                        <h2>Add Students</h2>
                        <span class="float-right btn-link" id="student-card-hide">Hide</span>
                    </div>
                    <div class="card-body-tm" id="student-card">
                        {{ HTML::ul($errors->all()) }}
                        {{ Form::open(array('url' => 'groups/adduser')) }}
                        <input name="group_id" type="hidden" value="{{$group->id}}">
                        <input name="user" type="hidden" value="student">
                        @foreach($schoolStudents as $student)
                            <div class="row p-2">
                                <label for="student{{$student->id}}" class="col-md-6">
                                    {{$student->student_id}}
                                </label>
                                <div class="col-md-6">
                                    <input id="student{{$student->id}}" type="checkbox" name="students[]" value="{{$student->id}}">
                                    <span class=""></span>
                                </div>
                            </div>
                        @endforeach
                        {{ Form::submit('Add student(s)', array('class' => 'btn btn-primary float-right mb-2 mt-2')) }}
                        {{ Form::close()  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-sm-12 card">
            <div class="row p-2 card-header">
                <h2>Staff Members</h2>
            </div>
            <div class="card-body-tm">
                @foreach($teachers as $teacher)
                    <div class="row p-2">
                        <div class="col-md-6">
                            <p>{{$teacher->name}}</p>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            @if(Auth::guard('teacher')->user()->id != $teacher->id)
                                {{ Form::open(array('url' => 'groups/removeuser')) }}
                                <input name="group_id" type="hidden" value="{{$group->id}}">
                                <input name="user" type="hidden" value="teacher">
                                <input name="teacher_id" type="hidden" value="{{$teacher->id}}">
                                {{ Form::submit('Remove', array('class' => 'btn btn-link p-0 width-100')) }}
                                {{ Form::close()  }}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-1 mb-2">
        </div>
        <div class="col-md-6 col-sm-12 card">
            <div class="row card-header d-flex justify-content-between">
                <h2>Add Staff</h2>
                <span class="float-right btn-link" id="teacher-card-hide">Hide</span>
            </div>
            <div class="card-body-tm" id="teacher-card">
                {{ HTML::ul($errors->all()) }}
                {{ Form::open(array('url' => 'groups/adduser')) }}
                <input name="group_id" type="hidden" value="{{$group->id}}">
                <input name="user" type="hidden" value="teacher">
                @foreach($schoolTeachers as $teacher)
                    <div class="row p-2">
                        <label for="teacher{{$teacher->id}}" class="col-md-6">
                            {{$teacher->name}}
                        </label>
                        <div class="col-md-6">
                            <input id="student{{$teacher->id}}" type="checkbox" name="teachers[]" value="{{$teacher->id}}">
                            <span class=""></span>
                        </div>
                    </div>
                @endforeach
                {{ Form::submit('Add staff(s)', array('class' => 'btn btn-primary float-right mb-2 mt-2')) }}
                {{ Form::close()  }}
            </div>
        </div>
    </div>
@endsection
