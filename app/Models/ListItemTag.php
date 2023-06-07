<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListItemTag extends Model
{
    use HasFactory;

    protected $table = 'list_item_tag';
    protected $guarded = false;

    public function tag(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}
