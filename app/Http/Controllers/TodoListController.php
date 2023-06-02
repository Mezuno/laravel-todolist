<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateTodoListRequest;
use App\Models\ListItem;
use App\Models\Tag;
use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
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

        return redirect()->route('list.show', ['listId' => $listId]);
    }

    public function deleteItem(Request $request)
    {
        $id = $request->input('id');

        $result = ListItem::where('id', $id)->delete();

        return $result;
    }

    public function index()
    {
        $lists = TodoList::where('owner_id', auth()->user()->id)
            ->withCount('item')
            ->withCount('checkedItem')
            ->get();
        return view('todolist.index', compact('lists'));
    }

    public function show(TodoList $list)
    {
        $tags = Tag::where('owner_id', auth()->user()->id)->get();
        $listItems = ListItem::where('todo_list_id', $list->id)->with('tags')->get();
        return view('todolist.show', compact('list', 'listItems', 'tags'));
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit(TodoList $list)
    {
        return view('todolist.edit', compact('list'));
    }

    public function update(UpdateTodoListRequest $request, TodoList $list)
    {
        $validated = $request->validated();
        TodoList::find($list->id)->update(['title' => $validated['title'], 'description' => $validated['description']]);
        return redirect()->route('list.show', ['list' => $list]);
    }

    public function delete(TodoList $list)
    {
        $list->delete();
        return redirect()->route('list.index')->with(['success' => 'Список успешно удален.']);
    }
}
