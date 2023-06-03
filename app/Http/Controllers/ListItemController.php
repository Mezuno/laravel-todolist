<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Models\ListItem;
use App\Models\TodoList;
use Illuminate\Http\Request;

class ListItemController extends Controller
{

    public function check(Request $request)
    {
        $id = $request->input('id');

        $result = ListItem::where('id', $id)->update(['checked' => true]);

        return $result;
    }

    public function uncheck(Request $request)
    {
        $id = $request->input('id');

        $result = ListItem::where('id', $id)->update(['checked' => false]);

        return $result;
    }

    public function updateItem(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $description = $request->input('description');
        $tags = $request->input('tags');

        $result = ListItem::where('id', $id)->update(['title' => $title, 'description' => $description]);

        $list = ListItem::where('id', $id)->get()->first();

        $list->tags()->sync($tags ?? []);

        return $result;
    }

    public function storeItem(StoreItemRequest $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $listId = $request->input('todo_list_id');

        $result = ListItem::create(['title' => $title, 'description' => $description, 'todo_list_id' => $listId]);

        $list = TodoList::find($listId);

        return redirect()->route('list.show', ['list' => $list]);
    }

    public function deleteItem(Request $request)
    {
        $id = $request->input('id');

        $result = ListItem::where('id', $id)->delete();

        return $result;
    }
}
