<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $todolists = TodoList::where('user_id', Auth::id())->get();
        return view('dashboard', compact('todolits'));
    }
    public function indexAPI()
    {
        $todolists = TodoList::where('user_id', Auth::id())->get();
        return response()->json([
            'status' => true,
            'message' => 'data di temukan',
            'todolist' => $todolists,


        ]);
    }
}
