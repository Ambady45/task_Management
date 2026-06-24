@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="text-2xl font-bold mb-4">
        Assign Users to Task
    </h2>

    <div class="mb-4">
        <strong>Task:</strong>
        {{ $task->title }}
    </div>

    <form
        action="{{ route('tasks.assign-users',$task->id) }}"
        method="POST"
    >
        @csrf

        @foreach($users as $user)

            <div class="mb-2">

                <input
                    type="checkbox"
                    name="users[]"
                    value="{{ $user->id }}"
                    id="user{{ $user->id }}"
                    {{ $task->users->contains($user->id) ? 'checked' : '' }}
                >

                <label for="user{{ $user->id }}">
                    {{ $user->name }}
                </label>

            </div>

        @endforeach

        <button
            type="submit"
            class="bg-green-500 text-white px-4 py-2 rounded"
        >
            Save Assignments
        </button>

    </form>

</div>

@endsection