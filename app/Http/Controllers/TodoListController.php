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
            ->get();
        return view('todolist.index', compact('lists'));
    }

    public function show(Request $request, TodoList $list)
    {
//        $validated['tags'] = ['title' => $request->input('search')];
//        $filter = app()->make(ListItemFilter::class, ['queryParams' => array_filter($validated ?? [])]);
        $tags = Tag::where('owner_id', auth()->user()->id)->get();
//        $listItems = ListItem::where('todo_list_id', $list->id)->with('tags')->get();


        $query = ListItem::query();

        if ($request->input('search')) {
            $search = '%'. $request->input('search') . '%';
            $query->whereHas('tags', function ($query) use ($search) {
                $query->where('title', 'like', $search);
            });
        }

        $listItems = $query->where('todo_list_id', $list->id)->with('tags')->get();

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
