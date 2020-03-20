
@extends('layout')

@section('content')
    <!-- if there are creation errors, they will show here -->
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => 'tasks/task')) }}
    <h1> Enter details to create a school</h1>

    <div class="form-group">
        <div class="form-input row mb-2">
            <label class="col-md-6" for="title">Title</label>
            <input class="col-md-6" type="text" name="title" id="title">
        </div>

        <div class="form-input mc-questions row mb-2">
            <label class="col-md-6" for="answer">Questions</label>
            <fieldset id="questions" class="checkbox-createtask">
            @foreach($questions as $question)
                <label class="question-container">
                    {{$question->Question}}
                    <input type="checkbox" name="questions[]" value="{{$question->id}}">
                    <span class="checkmark"></span>
                </label>
            @endforeach
            </fieldset>
        </div>


        <div class="form-input row mb-2">
            <label class="col-md-6" for="is-private">Make Task Private</label> <input class="col-md-6" type="checkbox" name="is-private" id="is-private">
        </div>

        <div class="form-input row mb-2">
            <label class="col-md-6" for="school">School</label> <input class="col-md-6" type="text" name="school" id="school">
        </div>
        <div class="form-input row mb-2">
            <label class="col-md-6" for="topic">Topic</label> <input class="col-md-6" type="text" name="topic" id="topic">
        </div>
    </div>

    {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
    {{ Form::close()  }}
@endsection
<script>
    $('#questions').find
</script>
