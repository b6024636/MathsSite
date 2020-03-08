
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

        <div class="form-group">
            <label>School Address</label>
            <div class="form-input">
                <label>Address Line 1</label> <input type="text" name="address1">
            </div>

            <div class="form-input">
                <label>Address Line 2</label> <input type="text" name="address2">
            </div>

            <div class="form-input">
                <label>Postcode</label> <input type="text" name="postcode">
            </div>

            <div class="form-input">
                <label>County</label> <input type="text" name="county">
            </div>

            <div class="form-input">
                <label>Country</label>
                <select id="country-list" name="country">
                    <option value="UK">United Kingdom</option>
                    <option value="USA">United States</option>
                </select>
            </div>
        </div>

        {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
    {{ Form::close()  }}
@endsection
