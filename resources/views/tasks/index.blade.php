@extends('layouts.app')

@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="d-flex justify-content-between mb-3">

    <h2>Tasks</h2>
    <div class="flex space-x-2">
    <a href="{{ route('tasks.create') }}"
       class="btn btn-primary">
        Create Task
    </a>
    <a href="{{ route('tasks.archived') }}"
   class="btn btn-secondary">
    Archived Tasks
</a>
</div>

</div>

<table class="table table-bordered">

    <thead>
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Owner</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

    @foreach($tasks as $task)

        <tr>

            <td>{{ $task->title }}</td>

            <td>{{ $task->status }}</td>

            <td>{{ $task->due_date }}</td>

            <td>{{ $task->owner->name }}</td>

            <td>

                <a href="{{ route('tasks.show',$task) }}"
                    class="btn btn-info btn-sm">
                    View
                </a>

                <a href="{{ route('tasks.edit',$task) }}"
                    class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form
                    action="{{ route('tasks.destroy',$task) }}"
                    method="POST"
                    style="display:inline"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Archive Task?')"
                    >
                        Archive
                    </button>
                    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Head'))

                    <a href="{{ route('tasks.assign.form', $task->id) }}"
                    class="btn btn-secondary btn-sm">
                        Assign Users
                    </a>

@endif

                </form>

            </td>

        </tr>

    @endforeach

    </tbody>

</table>



@endsection