<?php

namespace App\Http\Controllers;

use App\Http\Filters\ListItemFilter;
use App\Http\Requests\StoreTodoListRequest;
use App\Http\Requests\UpdateTodoListRequest;
use App\Models\ListItem;
use App\Models\Tag;
use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function index()
    {
        $lists = TodoList::where('owner_id', auth()->user()->id)
            ->withCount('item')
            ->withCount('checkedItem')
            ->orderByDesc('id')
            ->get();
        $accessedLists = auth()->user()
            ->accessedLists()
            ->with('owner')
            ->withCount('item')
            ->withCount('checkedItem')
            ->get();
        return view('todolist.index', compact('lists', 'accessedLists'));
    }

    public function show(Request $request, TodoList $list)
    {
        $this->authorize('view', [$list]);
        $tags = Tag::where('owner_id', auth()->user()->id)->get();

        $query = ListItem::query()->where('todo_list_id', $list->id)->with('tags');

        if ($request->input('tag')) {
            $tag = $request->input('tag');
            $query->whereHas('tags', function ($query) use ($tag) {
                $query->where('tag_id', '=', $tag);
            });
        }
        if ($request->input('search')) {
            $search = '%'. $request->input('search') . '%';
            $query->where('title', 'like', $search);
        }

        $listItems = $query->get();

        return view('todolist.show', compact('list', 'listItems', 'tags'));
    }

    public function create()
    {
        return view('todolist.create');
    }

    public function store(StoreTodoListRequest $request)
    {
        $validated = $request->validated();

        $validated['owner_id'] = auth()->user()->id;

        $list = TodoList::create($validated);

        return redirect()->route('list.show', ['list' => $list]);
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
