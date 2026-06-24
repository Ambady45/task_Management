@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4">

<div class="d-flex justify-content-between mb-3">

  
<h2>Archived Tasks</h2>
  <a href="{{ route('tasks.index') }}"
       class="btn btn-secondary">
        Back
    </a>
</div>

    

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-300">

        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Title</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Due Date</th>
                <th class="border p-2">Archived At</th>
                <th class="border p-2">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($tasks as $task)

                <tr>

                    <td class="border p-2">
                        {{ $task->title }}
                    </td>

                    <td class="border p-2">
                        {{ ucfirst($task->status) }}
                    </td>

                    <td class="border p-2">
                        {{ $task->due_date }}
                    </td>

                    <td class="border p-2">
                        {{ $task->deleted_at }}
                    </td>

                    <td class="border p-2">

                        <form action="{{ route('tasks.restore',$task->id) }}"
                              method="POST">

                            @csrf

                            <button
                                type="submit"
                                class="bg-green-500 text-white px-3 py-1 rounded">
                                Restore
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="text-center p-4">
                        No archived tasks found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection