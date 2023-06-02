<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListItemTag extends Model
{
    use HasFactory;

    protected $table = 'list_item_tags';
    protected $guarded = false;
}
