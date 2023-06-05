<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoList extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'todo_lists';
    protected $guarded = false;

    public function item()
    {
        return $this->hasMany(ListItem::class);
    }

    public function checkedItem()
    {
        return $this->hasMany(ListItem::class)->where('checked', '=', true);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
