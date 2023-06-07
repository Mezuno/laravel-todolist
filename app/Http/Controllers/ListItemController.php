<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListItemRequest;
use App\Http\Requests\UpdateListItemImageRequest;
use App\Http\Requests\UpdateListItemRequest;
use App\Models\ListItem;
use App\Models\TodoList;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ListItemController extends Controller
{
    public function check(ListItem $item)
    {
        return $item->update(['checked' => true]);
    }

    public function uncheck(ListItem $item)
    {
        return $item->update(['checked' => false]);
    }

    public function update(UpdateListItemRequest $request, ListItem $item)
    {
        $validated = $request->validated();

        $item->tags()->sync($validated['tags'] ?? []);
        unset($validated['tags']);

        return $item->update($validated);
    }

    public function store(StoreListItemRequest $request, TodoList $list)
    {
        $validated = $request->validated();
        $validated['todo_list_id'] = $list->id;
        ListItem::create($validated);
        return redirect()->route('list.show', ['list' => $list]);
    }

    public function delete(ListItem $item)
    {
        return $item->delete();
    }

    public function updateImage(UpdateListItemImageRequest $request, ListItem $item)
    {
        $validated = $request->validated();

        $filename = 'storage/images/list-items/' . $item->id . '.' . $validated['image']->getClientOriginalExtension();
        $filenameToDB = 'images/list-items/' . $item->id . '.' . $validated['image']->getClientOriginalExtension();

        ini_set('memory_limit','256M');
        $img = Image::make($validated['image']);
        $img->save(public_path($filename));

        $item->preview_image = $filenameToDB;
        $item->save();

        return $validated['image'];
    }

    public function removeImage(ListItem $item)
    {
        if (Storage::delete('/public/' . $item->preview_image)) {
            $item->preview_image = null;
        }
        return $item->save();
    }
}
