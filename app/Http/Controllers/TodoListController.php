<?php

namespace App\Http\Controllers;

use App\Http\Filters\ListItemFilter;
use App\Http\Requests\SaveSharedListRequest;
use App\Http\Requests\StoreTodoListRequest;
use App\Http\Requests\UpdateTodoListRequest;
use App\Models\ListItem;
use App\Models\SharedList;
use App\Models\SharedPermissionLevel;
use App\Models\Tag;
use App\Models\TodoList;
use App\Models\User;
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

        $query = ListItem::query()->where('todo_list_id', $list->id)->with('tags');

        if ($request->input('tags')) {
            $tags = $request->input('tags');
            $query->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('tag_id', $tags);
            });
        }

        if ($request->input('search')) {
            $search = '%'. $request->input('search') . '%';
            $query->where('title', 'like', $search);
        }

        $listItems = $query->get();
        $users = User::all();
        $sharedLists = SharedList::where('owner_id', auth()->user()->id)->where('list_id', $list->id)->get();
        $permissionLevels = SharedPermissionLevel::all();
        $tags = Tag::where('owner_id', auth()->user()->id)->get();

        return view('todolist.show', compact('list', 'listItems', 'tags', 'users', 'sharedLists', 'permissionLevels'));
    }

    public function share(SaveSharedListRequest $request, TodoList $list)
    {
        $validated = $request->validated();

        foreach ($validated['sharingList'] as $userId => $permissionLevel) {
            if ((int)$permissionLevel != 0) {
                SharedList::updateOrCreate([
                    'owner_id' => $list->owner_id,
                    'guest_id' => $userId,
                    'list_id' => $list->id,
                ], [
                    'permission_level' => $permissionLevel,
                ]);
            } else {
                SharedList::where('owner_id', $list->owner_id)
                    ->where('guest_id', $userId)
                    ->where('list_id', $list->id)
                    ->delete();
            }
        }

        return $validated['sharingList'];
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
