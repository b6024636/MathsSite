
@extends('layout')

@section('content')

    <h1>Here's a list of tasks</h1>
    <table class="table">
        <thead>
        <td>Title</td>
        <td>Marks Available</td>
        <td>Topic</td>
        <td>Rating</td>
        <td></td>
        </thead>
        <tbody>
        @foreach ($allTasks as $task)

            <tr>
                <td>{{ $task->title }}</td>
                <td class="inner-table">{{ $task->marks }}</td>
                <td class="inner-table">{{$task->topic}}</td>
                <td class="inner-table">{{ $task->rating }}</td>
                <td class="inner-table"><a href="/tasks/task/begintask/{{$task->id}}">Attempt task</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ config('app.url')}}/tasks/task/create">Add Task</a>
@endsection
