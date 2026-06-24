@extends('layouts.app')

@section('content')

<h2>Create Task</h2>

<form action="{{ route('tasks.store') }}"
      method="POST">

    @csrf

    <div class="mb-3">
        <label>Title</label>

        <input
            type="text"
            name="title"
            class="form-control"
        >
    </div>

    <div class="mb-3">
        <label>Description</label>

        <textarea
            name="description"
            class="form-control"
        ></textarea>
    </div>

    <div class="mb-3">
        <label>Due Date</label>

        <input
            type="date"
            name="due_date"
            class="form-control"
        >
    </div>

   

    <button class="btn btn-success">
        Save
    </button>

</form>

@endsection