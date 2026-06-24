@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">

  
<h2>{{ $task->title }}</h2>
  <a href="{{ route('tasks.index') }}"
       class="btn btn-secondary">
        Back
    </a>
</div>



<div class="card">

    <div class="card-body">

        <p>
            <strong>Description:</strong>
            {{ $task->description }}
        </p>

        <p>
            <strong>Status:</strong>
            {{ $task->status }}
        </p>

        <p>
            <strong>Due Date:</strong>
            {{ $task->due_date }}
        </p>

        <p>
            <strong>Owner:</strong>
            {{ $task->owner->name }}
        </p>

        <h5>Assigned Users</h5>

        <ul>

            @foreach($task->users as $user)

                <li>
                    {{ $user->name }}
                    ({{ $user->pivot->responsibility }})
                </li>

            @endforeach

        </ul>

    </div>

</div>

@endsection