
@extends('layout')

@section('content')
    <!-- if there are creation errors, they will show here -->
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => 'questions/question')) }}
    <h3>Create Question</h3>

    <div class="form-group">
        <div class="form-input row mb-2">
            <label class="col-md-6" for="question-type">Question Type</label>
            <select class="col-md-6" id="question-type" name="question-type">
                <option value="MC">Multiple Choice</option>
                <option value="SA">Single Answer</option>
            </select>
        </div>

        <div class="form-input row mb-2">
            <label class="col-md-6" for="question">Question</label>
            <textarea id="question" class="text col-md-6"  cols="50" rows ="15" name="question"></textarea>
        </div>

        <div class="form-input row mb-2">
            <label class="col-md-6" for="description">Brief Description</label>
            <input class="col-md-6" type="text" name="description" id="description" required>
        </div>

        <div class="form-input sa-question row mb-2">
            <label class="col-md-6" for="marks">Total Marks Available</label>
            <input class="col-md-6" type="number" name="marks" id="marks">
        </div>

        <div class="form-input mc-questions row mb-2">
            <label class="col-md-6" for="answer">Answer</label> <input class="col-md-6" type="text" name="answer" id="answer">
        </div>

        <div class="form-input mc-questions row mb-2" id="optional-answers-container">
            <label class="col-md-6" for="optional-answers">Optional Answers (Separate answers with comma)</label>
            <input class="col-md-6" type="text" name="optional-answers" id="optional-answers" placeholder="e.g. 7,0.1,100,200">
        </div>

        <div class="form-input row mb-2">
            <label class="col-md-6" for="is-private">Make Question Private</label> <input class="col-md-6" type="checkbox" name="is-private" id="is-private">
        </div>

        <div class="form-input row mb-2">
            <label class="col-md-6" for="topic">Topic</label>
            <select class="col-md-6" name="topic" id="topic">
                @foreach($topics as $topic)
                    <option value="{{$topic->id}}">{{$topic->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
    {{ Form::close()  }}
    <script>
        $('#question-type').change(function(){
            if($('#question-type').val() =='MC'){
                $('#optional-answers-container').removeClass('hide');
            }
            else{
                $('#optional-answers-container').addClass('hide');
            }
        });
    </script>
@endsection
