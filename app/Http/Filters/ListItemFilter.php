<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ListItemFilter extends AbstractFilter
{
    const TAGS = 'tags';

    protected function getCallbacks(): array
    {
        return [
            self::TAGS => [$this, 'tags'],
        ];
    }

    protected function tags(Builder $builder, $value)
    {
        return $builder->whereHas('tags', function ($b) use ($value) {
            $b->whereIn('title', $value);
        });
    }
}
