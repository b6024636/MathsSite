
@extends('layout')

@section('content')
    <!-- if there are creation errors, they will show here -->
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => 'questions/question')) }}
    <h1> Enter details to create a school</h1>

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
            <label class="col-md-6" for="description">Description</label>
            <textarea id="description" class="text col-md-6"  cols="50" rows ="15" name="description"></textarea>
        </div>

        <div class="form-input sa-question row mb-2">
            <label class="col-md-6" for="marks">Total Marks Available</label>
            <input class="col-md-6" type="number" name="marks" id="marks">
        </div>

        <div class="form-input mc-questions row mb-2">
            <label class="col-md-6" for="optional-answers">Optional Answers</label> <input class="col-md-6" type="text" name="optional-answers" id="optional-answers">
        </div>

        <div class="form-input row mb-2">
            <label class="col-md-6" for="is-private">Make Question Private</label> <input class="col-md-6" type="checkbox" name="is-private" id="is-private">
        </div>

        <div class="form-input row mb-2">
            <label class="col-md-6" for="school">School</label> <input class="col-md-6" type="text" name="school" id="school">
        </div>
    </div>

    {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
    {{ Form::close()  }}
@endsection
