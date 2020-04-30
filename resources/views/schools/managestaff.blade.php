
@extends('layout')

@section('content')
    <h1>Manage Staff</h1>
    <a href="/myschool">&laquo Back to my school</a><br>
    <i>Resetting a password sets it to be a username with 5 0's appended to it. e.g. JDoe00000</i>
    <div class="card mt-3">
        <div class=" col-md-12 table card-body task-table">
            <div class="row mb-2">
                <div class="col-md-3 col-sm-1">
                    <strong>Username</strong>
                </div>
                <div class="col-md-3 col-sm-1">
                </div>
                <div class="col-md-3 col-sm-1">
                </div>
            </div>

            {{--            @if(count($tasks) > 0)--}}
            @foreach ($staff as $_staff)
                <div class="row task-row d-flex justify-content-between pt-1 pb-1">
                    <div class="col-md-3 task-title pt-2">{{ $_staff->username }}</div>
                    <div class="col-md-3 reset-password">
                        <input type="hidden" class="reset-pass-id" name="id" value="{{$_staff->id}}">
                        <a class="btn btn-sm btn-primary reset-password-btn">Reset password</a>
                    </div>
                    <div class="col-md-3 delete-user">
                        <input type="hidden" class="delete-user-id" name="id" value="{{$_staff->id}}">
                        <a class="btn btn-sm btn-danger delete-user-btn">Delete user</a>
                    </div>
                </div>
            @endforeach
            {{--                            @endif--}}
        </div>
    </div>
    <script>
        $('.reset-password-btn').click(function(){
            event.preventDefault();
            let $data = {user: 'teacher', id: $(this).closest('.reset-password').find('.reset-pass-id').val()},
                $button = $(this);
            $.ajax({
                url: '/resetPassword',
                data: $data,
                type: 'GET',
                success: function(data, success){
                    if(data == 'success'){
                        $button.addClass('disabled');
                        $button.html('Password reset');
                    }
                }
            })
        });
        $('.delete-user-btn').click(function(){
            event.preventDefault();
            let $data = {user: 'teacher', id: $(this).closest('.delete-user').find('.delete-user-id').val()},
                $button = $(this);
            $.ajax({
                url: '/deleteuser',
                data: $data,
                type: 'GET',
                success: function(data, success){
                    if(data == 'success'){
                        $button.closest('.row').remove();
                    }
                }
            })
        });
    </script>
@endsection
