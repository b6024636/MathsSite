
@extends('layout')

@section('content')
    <!-- if there are creation errors, they will show here -->
    {{ HTML::ul($errors->all()) }}
    {{ Form::open(array('url' => 'schools/school')) }}
        <h1> Enter details to create a school</h1>
        <div class="form-input">
            <label>Name</label> <input type="text" name="name">
        </div>

        <div class="form-input">
            <label>Contact Number</label> <input type="text" name="contact">
        </div>

        <div class="form-input">
            <label>Email</label> <input type="email" name="email">
        </div>

        <div class="form-group">
            <label for="imageInput">File input</label>
            <input data-preview="#preview" name="logo" type="file" id="imageInput">
            <img class="col-sm-6" id="preview" alt="" src=""/>
            <p class="help-block">Example block-level help text here.</p>
        </div>

        {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
    {{ Form::close()  }}
@endsection
