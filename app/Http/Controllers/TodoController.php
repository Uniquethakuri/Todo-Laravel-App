<?php

namespace App\Http\Controllers;

use App\Repositories\TodoRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Todo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth; 

class TodoController extends Controller
{
    use AuthorizesRequests;

    protected $todos;

    public function __construct(TodoRepositoryInterface $todos)
    {
        $this->todos = $todos;
    }

    public function index()
    {
        $todos = $this->todos->all(null); 
        return view('todos.index', compact('todos'));
    }

    public function create()
    {
        $this->authorize('create', Todo::class);
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $todo = Todo::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'user_id' => Auth::id(), 
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Todo created successfully',
                'redirect' => route('todos.index'),
            ]);
        }

        return redirect()->route('todos.index')->with('success', 'Todo created successfully');
    }

    public function edit(Todo $todo)
    {
        $this->authorize('update', $todo);
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        if ($todo->update($request->all())) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);
        $this->todos->delete($todo->id);

        return redirect()->route('todos.index')->with('success', 'Task deleted successfully.');
    }
}
