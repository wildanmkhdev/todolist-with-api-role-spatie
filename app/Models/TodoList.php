<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    protected $fillable = [
        'user_id',
        'task',
        'is_completed'
    ];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    //

}
