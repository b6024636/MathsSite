
{{--@extends('layouts.auth')--}}
@extends('layout');
@section('content')
    @auth("admin")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        Hi {{Auth::guard('admin')->user()->name}}!
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Questions</div>

                        <div class="card-body">
                            <a href="{{ config('app.url')}}/questions/question/create">Create Question</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Tasks</div>

                        <div class="card-body">
                            Create Task {{Auth::guard('admin')->user()->name}}!
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endauth
    @if(!Auth::guard('admin')->check())

        <script>
            window.location.href('/login/admin');
        </script>
        hi
    @endif
@endsection
