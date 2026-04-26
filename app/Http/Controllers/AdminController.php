<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $todolist = TodoList::with('user')->get();
        // variale todolist akan nyar data di model todolist dengan relasi user bersangkutan
        return view("admin.index", compact('todolist'));
        // stelah data di dapatkan lempar data ke halaman index di foler admin dengan compca todolist
    }
}
