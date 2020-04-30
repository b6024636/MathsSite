
@extends('layout')

@section('content')
    <!-- if there are creation errors, they will show here -->
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('method' => 'PUT', 'route' => ['task.update', $chosenTask->id])) }}
    <div class="card">
        <div class="card-header">
            <h1>Edit task details</h1>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="form-input row mb-2">
                    <label class="col-md-6 font-weight-bold" for="title">Title</label>
                    <input class="col-md-6" type="text" name="title" id="title" value="{{$chosenTask->title}}" required>
                </div>

                <div class="form-input mc-questions row mb-2">
                    <label class="col-md-6 font-weight-bold" for="questions">Questions</label>
                    <input type="hidden" id="questions" name="questions" value="{{$chosenTask->questions}}">
                    <div class="d-flex flex-column">
                        <i>Questions added in order they are checked.</i>
                        <button type="button" data-toggle="modal" data-target="#task-modal" class="float-right btn btn-primary mb-1" id="add-work">Click to add questions</button>
                    </div>
                    <p id="question-count" class="ml-4"><strong>0 Questions Added</strong></p>

                </div>

                <div class="form-input row mb-2">
                    <label class="col-md-6 font-weight-bold" for="is-private">Make Task Private</label> <input class="col-md-6" type="checkbox" name="is-private" id="is-private">
                </div>


                <div class="form-input row mb-2">
                    <label class="col-md-6 font-weight-bold" for="topic">Topic</label>
                    <select class="col-md-6" name="topic" id="topic">
                        @foreach($topics as $topic)
                            <option value="{{$topic->id}}" {{$topic->id == $chosenTask->topic ? 'selected="selected"' : ''}}>{{$topic->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{ Form::submit('Create', array('class' => 'btn btn-primary', 'id' => 'submit-btn')) }}
            {{ Form::close()  }}
        </div>
    </div>
    <div class="modal fade" id="task-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h2 class="modal-title">Edit Questions For Task</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="topics-body">
                    @foreach($allQuestions as $topic)
                        <div class="row p-2 topic-row">
                            <a href="#" class="topic-link" data-title="{{$topic['title']}}">{{$topic['title']}} &raquo;</a>
                            <div class="hide topic-tasks">
                                {{json_encode($topic['questions'])}}
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
        let questions = $('#questions').val().split(',');
        $('#question-count').html('<strong>' + questions.length + ' Quesiton(s) Added</strong>');
        $('.topic-link').click(function(){
            event.preventDefault();
            let $row = $(this).closest('.topic-row'),
                $title = $(this).attr('data-title'),
                $questions = JSON.parse($row.find('.topic-tasks:first').html());


            let $html = '<a href="#" id="topic-back">&laquo Back to topics</a>';

            if($questions != '[]') {
                $html += '<div class="row p-2 task-row font-weight-bold">' +
                    '<div class="col-md-12">' +
                    '<p>Descirption</p>' +
                    '</div>' +
                    '</div>';
                for (var k in $questions) {
                    let checked = '';
                    if(questions.includes(($questions[k].id).toString()))
                        checked = 'checked';
                    $html += '' +
                        '<div class="row p-2 task-row">' +
                        '<div class="col-md-12">' +
                        '<label class="d-flex justify-content-between">' +
                        '<p>' + $questions[k].description + '</p>' +
                        '<input type="checkbox" name="questionsBox" value="' + $questions[k].id + '" class="question-checkbox" ' + checked + '>\n' +
                        '</label>' +
                        '</div>' +
                        '</div>';
                }
            }else{
                $html += '<div class="row p-2 task-row font-weight-bold">' +
                    '<p>N/A</p>' +
                    '</div>'
            }
            $('#tasks-body').html($html);
            $('.question-checkbox').change(function(){
                if($(this).is(":checked")){
                    questions.push($(this).val());
                }
                else{
                    let index = questions.indexOf($(this).val());
                    questions.splice(index, 1);
                }
                $('#questions').val(questions.toString());
                $('#question-count').html('<strong>' + questions.length + ' Quesiton(s) Added</strong>');
                if(questions.length > 0){
                    $('#submit-btn').removeClass('disabled');
                }
                else{
                    $('#submit-btn').addClass('disabled');
                }
            });
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
