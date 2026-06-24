@extends('layouts.app')

@section('content')


@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="d-flex justify-content-between mb-3">
<h2>Edit Task</h2>
    <a href="{{ route('tasks.index') }}"
         class="btn btn-secondary">
            Back
        </a>    
        </div>
    

<form action="{{ route('tasks.update',$task) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">

        <label>Title</label>

        <input
            type="text"
            name="title"
            value="{{ $task->title }}"
            class="form-control"
        >
    </div>

    <div class="mb-3">

        <label>Description</label>

        <textarea
            name="description"
            class="form-control"
        >{{ $task->description }}</textarea>

    </div>

    <div class="mb-3">

        <label>Status</label>

        <select
            name="status"
            class="form-control"
        >

            <option value="pending"
            {{ $task->status=='pending'?'selected':'' }}>
                Pending
            </option>

            <option value="in_progress"
            {{ $task->status=='in_progress'?'selected':'' }}>
                In Progress
            </option>

            <option value="completed"
            {{ $task->status=='completed'?'selected':'' }}>
                Completed
            </option>

        </select>

    </div>
    <div class="mb-3">
    <label>Due Date</label>

    <input type="date"
        name="due_date"
        value="{{ $task->due_date }}"
        class="form-control"
        {{ auth()->id() != $task->owner_id ? 'disabled' : '' }}>
        </div>

    <button class="btn btn-primary">
        Update
    </button>

</form>




@endsection