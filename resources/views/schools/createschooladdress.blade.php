<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}
{{ Form::open(array('url' => 'school/schooladdress')) }}
<h1> Enter details to create a school</h1>
<div class="form-input">
    <label>Address1</label> <input type="text" name="address1">
</div>

<div class="form-input">
    <label>Address2</label> <input type="text" name="address2">
</div>

<div class="form-input">
    <label>Postcode</label> <input type="text" name="postcode">
</div>

<div class="form-input">
    <label>County</label> <input type="text" name="county">
</div>

<div class="form-input">
    <label>Country</label> <input type="text" name="country">
</div>

{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
{{ Form::close()  }}
