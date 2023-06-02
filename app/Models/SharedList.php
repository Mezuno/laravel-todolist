<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedList extends Model
{
    use HasFactory;

    protected $table = 'shared_lists';
    protected $guarded = false;
}