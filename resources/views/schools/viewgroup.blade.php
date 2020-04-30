
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
                            <div class="col-md-6 col-sm-6">
                                <p>{{$student->student_id}}</p>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                {{ Form::open(array('url' => 'groups/studentwork')) }}
                                <input name="student_id" type="hidden" value="{{$student->id}}">
                                <input name="group_id" type="hidden" value="{{$group->id}}">
                                {{ Form::submit('Check work', array('class' => 'btn btn-link p-0 width-100')) }}
                                {{ Form::close()  }}
                            </div>
                            <div class="col-md-3 col-sm-3">
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
                    @foreach($tasks as $task)
                        <div class="row p-2">
                            <div class="col-md-6">
                                <p>{{$task->title}}</p>
                            </div>
                            <div class="col-md-3">
                                {{ Form::open(array('url' => 'groups/taskresults')) }}
                                <input type="hidden" name="task_id" value="{{$task->id}}">
                                <input type="hidden" name="group_id" value="{{$group->id}}">
                                {{ Form::submit("View Results", array("class" => "btn btn-link p-0 width-100")) }}
                                {{ Form::close()  }}
                            </div>
                            <div class="col-md-3">
                                {{ Form::open(array('url' => 'groups/removework')) }}
                                <input type="hidden" name="task_id" value="{{$task->id}}">
                                <input type="hidden" name="group_id" value="{{$group->id}}">
                                {{ Form::submit("Remove", array("class" => "btn btn-link p-0 width-100")) }}
                                {{ Form::close()  }}
                            </div>
                        </div>
                    @endforeach
                    <div class="row p-2">
                        <div class="col-md-12">
                            <button type="button" data-toggle="modal" data-target="#task-modal" class="float-right btn btn-primary mb-1" id="add-work">Add work to group</button>
                        </div>
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
    <div class="modal fade" id="task-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h2 class="modal-title">Add a task for the group</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="topics-body">
                    @foreach($availableTasks as $topic)
                        <div class="row p-2 topic-row">
                            <a href="#" class="topic-link" data-title="{{$topic['title']}}">{{$topic['title']}} &raquo;</a>
                            <div class="hide topic-tasks">
                                {{json_encode($topic['tasks'])}}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-body hide " id="tasks-body">

                </div>
            </div>
        </div>
    </div>
    <script>
        $('.topic-link').click(function(){
            event.preventDefault();
            let $row = $(this).closest('.topic-row'),
                $title = $(this).attr('data-title'),
                $tasks = JSON.parse($row.find('.topic-tasks:first').html());
            console.log($tasks);


            let $html = '<a href="#" id="topic-back">&laquo Back to topics</a>';

            if($tasks != '[]') {
                $html += '<div class="row p-2 task-row font-weight-bold">' +
                    '<div class="col-md-4">' +
                    '<p>Title</p>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<p>Marks</p>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<p>Rating</p>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<p></p>' +
                    '</div>' +
                    '</div>';
                for (var k in $tasks) {
                    $html += '' +
                        '<div class="row p-2 task-row">' +
                        '<div class="col-md-4">' +
                        '<p>' + $tasks[k].title + '</p>' +
                        '</div>' +
                        '<div class="col-md-3">' +
                        '<p>' + $tasks[k].marks + '</p>' +
                        '</div>' +
                        '<div class="col-md-3">' +
                        '<p>' + $tasks[k].rating + '</p>' +
                        '</div>' +
                        '<div class="col-md-2">' +
                        ' {{ Form::open(array("url" => "groups/addwork")) }}' +
                        '<input type="hidden" value="'+ $tasks[k].id +'" name="task_id">' +
                        '<input type="hidden" value="{{$group->id}}" name="group_id">' +
                        '{{ Form::submit("Add", array("class" => "btn btn-link p-0 width-100")) }}\n' +
                        '{{ Form::close()  }}' +
                        '</div>' +
                        '</div>';
                }
            }else{
                $html += '<div class="row p-2 task-row font-weight-bold">' +
                    '<p>N/A</p>' +
                    '</div>'
            }
            $('#tasks-body').html($html);
            $('#topics-body').hide();
            $('#tasks-body').show();
            $('.modal-title').html($title);
            $('#topic-back').click(function(){
                event.preventDefault();
                $('#tasks-body').hide();
                $('#tasks-body').html('');
                $('.modal-title').html('Add a task for the group');
                $('#topics-body').show();
            })
        });
    </script>
@endsection
