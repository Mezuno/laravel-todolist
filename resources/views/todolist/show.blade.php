@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{ route('list.index') }}" class="btn btn-dark btn-sm mb-3">
                    <i class="fas fa-arrow-left"></i>
                    Назад
                </a>

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="fw-bold mt-2">{{ $list->title }}</h1>
                    <div class="dropdown cursor-pointer">

                        <a id="dropdownMenu" class="cursor-pointer text-dark dropdown-toggle"
                           role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false" v-pre>
                            <i class="fas fa-ellipsis-v"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="dropdownMenu">
                            <a href="{{ route('list.edit', ['list' => $list]) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
                            <form action="{{ route('list.delete', ['list' => $list]) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-danger ms-2"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="card-body">

                    <div class="mb-3">{{ $list->description }}</div>

                    <div id="itemList">
                        @foreach($listItems as $item)
                            <div class="p-1 border-secondary border my-2 rounded-3 d-flex
                            justify-content-between align-items-center hoverDiv" id="item{{ $item->id }}">
                                <div class="mx-2">
                                    <p class="m-0 p-0" id="titleItem{{ $item->id }}">{{ $item->title }}
                                        @foreach($item->tags as $tag)
                                            <span class="alert alert-warning px-2 py-0 me-1">{{ $tag->title }}</span>
                                        @endforeach</p>
                                    <p class="text-secondary m-0 p-0" id="descriptionItem{{ $item->id }}">{{ $item->description }}</p>
                                    <div class="my-2">
                                    </div>
                                </div>
                                <div class="mx-2">
                                    <a type="button" class="text-secondary mx-3" data-bs-toggle="modal" data-bs-target="#modalItem{{ $item->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    @if($item->checked)
                                        <button onclick="checkItem({{ $item->id }})" id="checkButton{{ $item->id }}" class="rounded-3 btn-sm btn btn-dark"><i class="fas fa-check"></i></button>
                                    @else
                                        <button onclick="checkItem({{ $item->id }})" id="checkButton{{ $item->id }}" class="rounded-3 btn-sm btn btn-outline-dark text-white"><i class="fas fa-check"></i></button>
                                    @endif
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalItem{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Редактирование пункта</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="">
                                                <input type="text" id="titleInputItem{{ $item->id }}" class="form-control mb-2" value="{{ $item->title }}">
                                                <input type="text" id="descriptionInputItem{{ $item->id }}" class="form-control" value="{{ $item->description }}">

                                                @if ($errors->has('tags'))
                                                    <div class="alert alert-danger w-100">
                                                        <ul>@foreach($errors->get('tags') as $message)<li>{{$message}}</li>@endforeach</ul>
                                                    </div>
                                                @endif

                                                <div class="form-group mt-2">
                                                    <select name="tags[]" class="tags" id="tagsItem{{ $item->id }}" multiple="multiple" data-placeholder="Добавить тег" style="height: 500px; width: 100%;">
                                                        @foreach($tags as $tag)
                                                            @foreach($item->tags as $itemTag)
                                                                @if($itemTag->id == $tag->id)
                                                                    {{ $selected = 'selected' }}
                                                                    @break
                                                                @else
                                                                    {{ $selected = '' }}
                                                                @endif
                                                            @endforeach
                                                            <option {{ $selected ?? '' }} value="{{ $tag->id }}">{{ $tag->title }}</option>
                                                            {{ $selected = '' }}
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </form>

                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" onclick="deleteItem({{ $item->id }})">Удалить</button>
                                            <div>
                                                <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Закрыть</button>
                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="editItem({{ $item->id }})">Сохранить</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                        <div class="p-1 border-secondary border mt-2 p-2 rounded-3 d-flex flex-column" id="newItem">
                            <form action="{{ route('item.store') }}" method="post">
                                @csrf
                                @method('post')
                                <input type="text" class="form-control mb-2" name="title" placeholder="Название">
                                <textarea type="text" class="form-control mb-2" name="description" placeholder="Описание"></textarea>
                                <input type="text" value="{{ $list->id }}" name="todo_list_id" hidden>
                                <button class="btn btn-success">Добавить</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
