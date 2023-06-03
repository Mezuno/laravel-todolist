<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::where('owner_id', auth()->user()->id)->orderByDesc('id')->get();
        return view('tag.index', compact('tags'));
    }

    public function create()
    {
        return view('tag.create');
    }

    public function store(StoreTagRequest $request)
    {
        $validated = $request->validated();

        $validated['owner_id'] = auth()->user()->id;

        Tag::create($validated);

        return redirect()->route('tag.index')->with(['success' =>  'Тег ' . $validated['title'] . ' успешно создан.']);
    }

    public function edit(Tag $tag)
    {
        return view('tag.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $validated = $request->validated();

        $tag->update($validated);

        return redirect()->route('tag.index')->with(['success' =>  'Тег ' . $validated['title'] . ' успешно обновлен.']);
    }

    public function delete(Tag $tag)
    {
        $tagTitle = $tag->title;
        $tag->delete();
        return redirect()->route('tag.index')->with(['success' =>  'Тег ' . $tagTitle . ' успешно удален.']);
    }
}
