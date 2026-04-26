<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTodolistRequest;
use App\Http\Requests\UpdateTodolistRequest;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            // jika role yang masuk adllaha admin
            $todolist = Todolist::all();
            // semua da ta todolist bsa di lihat dan di ambil
            # code...
        } else {
            $todolist = Todolist::where('user_id', auth()->id())->get();
        }
        return response()->json([
            'status' => true,
            'message' => 'todolist suskses loaded',
            'data' => $todolist,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required' | 'string' | 'max:255'
        ]);
        // jika berhasi tofolist akan create data ke database
        Todolist::create([
            'is_task' => $request->task,
            'is_completed' => $request->has('is_completed') ? 1 : 0,
            'user_id' => auth()->id(), //simpan user id yang sedang login

        ]);
        return redirect()->back()->with('sucess', 'task success created');
    }

    /**
     * Store a newly created resource in storage.
     */


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        $todo = Todolist::findOrFail($id);
        if (auth()->user()->hasRole('user') && $todo->user_id !== Auth::id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $request->validate([
            'task' => 'sometimess|string|max:255',
            'is_completed' => 'sometimes|boolean'
        ]);
        // ambil data yang dikirim
        $data = $request->only('task', 'is_completed');
        if (!$request->has('is_completed')) {
            $data['is_completed'] = 0;
        }
        $todo->update($data);
        return redirect()->back()->with('success', "task success update");
    }


    public function destroy(string $id)
    {
        $todo = Todolist::findOrFail($id);
        $todo->delete();
        return redirect()->back()->with('success', 'tasl sucesss deleted');
    }
    // keperluan api
    public function storeAPI(Request $request, $id)
    {
        $request->validate([
            'task' => 'required' | 'string' | 'max:255'
        ]);
        // jika berhasi tofolist akan create data ke database
        $todolist =  Todolist::create([
            'is_task' => $request->task,
            'is_completed' => $request->has('is_completed') ? 1 : 0,
            'user_id' => auth()->id(), //simpan user id yang sedang login

        ]);
        return response()->json([
            'status' => true,
            'message' => 'todolsit sukses',
            'data' => $todolist,

        ]);
    }
    public function updateAPI(Request $request, $id)
    {
        $todo = Todolist::findOrFail($id);
        if (auth()->user()->hasRole('user') && $todo->user_id !== Auth::id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $request->validate([
            'task' => 'sometimess|string|max:255',
            'is_completed' => 'sometimes|boolean'
        ]);
        // ambil data yang dikirim
        $data = $request->only('task', 'is_completed');
        if (!$request->has('is_completed')) {
            $data['is_completed'] = 0;
        }
        $todo->update($data);
        return response()->json([
            'status' => true,
            'message' => 'todolsit sukses',
            'data' => $todo,

        ]);
    }
    public function destoryAPI($id)
    {
        $todo = Todolist::findOrFail($id);
        if (auth()->user()->hasRole('user') && $todo->user_id !== Auth::id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $todo->delete();
        return response()->json([
            'status' => true,
            'message' => 'todolsit sukses',
            'data' => $todo,

        ]);
    }
}
