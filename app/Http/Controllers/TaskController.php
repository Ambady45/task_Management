<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            $tasks = Task::all();
        } elseif ($user->hasRole('Head')) {
            $tasks = Task::where('owner_id', $user->id)->get();
        } else {
            $tasks = $user->tasks()->get()  ;  
    }

         return view('tasks.index', compact('tasks'));
    }
    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            ]);
             $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
            'due_date' => $request->due_date,
            'owner_id' => Auth::id(),
        ]);

        
        $task->users()->attach(Auth::id(), ['responsibility' => 'owner']);
           // Head/Admin can assign users
        if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Head')) {
            $userIds = $request->input('user_ids', []);
            foreach ($userIds as $userId) {
                $task->users()->attach($userId, ['responsibility' => 'contributor']);
            }
        }
         

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        
       $this->authorize('view', $task);

        return view('tasks.show', compact('task'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'date|',
        ]);

            $user=Auth::user();
        
     /*   if ($request->status == 'completed'&&
            now()->lt($task->due_date)&&
            $task->owner_id != $user->id&&
            !$user->hasRole('Admin')&&
            !$user->hasRole('Head')
        ) {

            return back()
                ->withErrors([
                    'status' =>
                    'Cannot complete task before due date.'
                ]);
        }*/
        
    //i need the duedatei sfuture date and only owner,admin can update the status into cmpleted
   if (
    $request->status === 'completed' &&
    Carbon::parse($task->due_date)->isFuture()) {
    return back()->withInput()->withErrors([
            'status' => 'Task cannot be completed before the due date.'
        ]);
    }
         

             $data = [
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,];

    // Only owner can update due date
        if ($user->id == $task->owner_id) {
        $data['due_date'] = $request->due_date;
        }

          $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        if ($task->users()->count() > 1) {

            return back()
                ->withErrors([
                    'delete' =>'Task has multiple assigned users.so cannot be deleted.']);
        }
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }


    public function assignUsers(Request $request, Task $task)
        {
        $request->validate([
        'users' => 'nullable|array'
        ]);

     $syncData = [];

    foreach ($request->users ?? [] as $userId) {

        $syncData[$userId] = [
            'responsibility' => 'contributor'
        ];
    }

    // keep owner attached
    $syncData[$task->owner_id] = [
        'responsibility' => 'owner'
    ];

    $task->users()->sync($syncData);

    return redirect()
        ->route('tasks.index')
        ->with(
            'success',
            'Users assigned successfully.'
        );
}
   
    //remove user from task
    public function removeUser(Task $task, User $user){
        $authUser = Auth::user();
        if ( !$authUser->hasRole('Admin')   
            &&!($authUser->hasRole('Head')&& $task->owner_id == $authUser->id)
        ) {
            abort(403);
        }   
        $task->users()->detach($user->id);
        return back()->with('success', 'User removed from task successfully.');
    }
    //archived task
    public function archived(){
        $tasks = Task::onlyTrashed()->get();
        return view('tasks.archived', compact('tasks'));
    }
    public function restore($id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();
        return redirect()->route('tasks.archived')->with('success', 'Task restored successfully.');
    }
    //updateduedate
    public function updateDueDate(Request $request, Task $task){
        if($task->owner_id != Auth::id()) {
             abort(403);
        }
        request()->validate(['due_date' => 'required|date']);
        $task->update(['due_date' => $request->due_date]);
        return back()->with('success', 'Due date updated successfully.');

    }
    public function assignUserForm(Task $task)
    {
    if (
        !auth()->user()->hasRole('Admin') &&
        !auth()->user()->hasRole('Head')
    ) {
        abort(403);
    }

    $users = User::where('id', '!=', auth()->id())->get();

    return view('tasks.assign-users',compact('task', 'users')
    );
    }
}

    
    

