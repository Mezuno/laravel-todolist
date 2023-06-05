<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedList extends Model
{
    use HasFactory;
    public const VIEW_ACCESS_CODE = 1;
    public const CHECK_ACCESS_CODE = 2;
    public const EDIT_ACCESS_CODE = 3;

    protected $table = 'shared_lists';
    protected $guarded = false;
}
