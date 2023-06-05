<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedPermissionLevel extends Model
{
    use HasFactory;

    protected $table = 'shared_permission_levels';
    protected $guarded = false;
}
