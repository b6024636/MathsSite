
@extends('layout')

@section('content')
            <!-- if there are creation errors, they will show here -->
            {{ HTML::ul($errors->all()) }}
            {{ Form::open(array('url' => 'schooltest')) }}
                <h1> Enter details to create a school</h1>
                <div class="form-input">
                    <label>Name</label> <input type="text" name="name">
                </div>

                <div class="form-input">
                    <label>Address</label> <input type="text" name="address">
                </div>

                <div class="form-input">
                    <label>Contact</label> <input type="text" name="contact">
                </div>

                <div class="form-input">
                    <label>Description</label> <textarea id="confirmationText" class="text"  cols="50" rows ="15" name="description"></textarea>
                </div>

            {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
            {{ Form::close()  }}
@endsection
