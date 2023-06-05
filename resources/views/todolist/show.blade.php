@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{ route('list.index') }}" class="btn btn-dark btn-sm mb-3">
                    <i class="fas fa-arrow-left"></i>
                    Назад
                </a>

                @if($list->owner_id !== auth()->user()->id)
                    <div class="alert alert-info p-2 py-1">
                        Список пользователя {{ $list->owner->name }}. Вас пригласили.
                    </div>
                @endif

                <div class="mb-2">
                    <h5>Фильтр по тегам</h5>
                    @foreach($tags as $tag)
                        <form action="{{ route('list.show', ['list' => $list]) }}" class="d-inline-block">
                            <input type="text" value="{{ $tag->id }}" name="tag" hidden>
                            <button class="alert p-0 px-1 me-2 @if($tag->id == app('request')->input('tag')) alert-danger @else alert-warning @endif">{{ $tag->title }}</button>
                        </form>
                    @endforeach
                    @if(app('request')->input('tag'))
                        <form action="{{ route('list.show', ['list' => $list]) }}" class="d-inline-block">
                            <button class="alert alert-secondary p-0 px-1"><i class="fas fa-times"></i></button>
                        </form>
                    @endif
                </div>

                <div class="d-flex mb-3">
                    @if(app('request')->input('search'))
                        <form action="{{ route('list.show', ['list' => $list]) }}">
                            <button class="btn btn-outline-secondary"><i class="fas fa-times"></i></button>
                        </form>
                    @endif
                    <form action="{{ route('list.show', ['list' => $list]) }}" class="d-flex w-100">
                        <input type="text" class="form-control border border-dark" name="search" value="{{ app('request')->input('search') }}" placeholder="Поиск">
                        <button class="btn btn-outline-dark"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="fw-bold mt-2">{{ $list->title }}</h1>
                    <div class="dropdown cursor-pointer">

                        <a id="dropdownMenu" class="cursor-pointer text-dark dropdown-toggle"
                           role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false" v-pre>
                            <i class="fas fa-ellipsis-v"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="dropdownMenu">
                            @can('share', [$list])
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalSharing">
                                    <i class="fas fa-share-square"></i></button>
                            @endcan
                            @can('update', [$list])
                                <a href="{{ route('list.edit', ['list' => $list]) }}" class="btn btn-sm btn-primary ms-1">
                                    <i class="fas fa-pen"></i></a>
                            @endcan
                            @can('delete', [$list])
                                <form action="{{ route('list.delete', ['list' => $list]) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-danger ms-1"><i class="fas fa-trash"></i></button>
                                </form>
                            @endcan
                        </div>

                        <div class="modal fade" id="modalSharing" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Поделиться списком</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="" id="shareForm">
                                            @foreach($users as $user)
                                                @if($user->id != auth()->user()->id)
                                                <div class="d-flex justify-content-between mb-2">
                                                    {{ $user->name }}

                                                    <select name="sharingList[]" class="form-select-sm sharingList" data-user-id="{{ $user->id }}" style="">

                                                        {{ $sharedList = $sharedLists->first(function($list) use ($user) {
                                                            return $list->guest_id == $user->id;
                                                        }) }}

                                                        @if($sharedList)
                                                            @foreach($permissionLevels as $permissionLevel)
                                                                @if($permissionLevel->id === $sharedList->permission_level)
                                                                    <option selected
                                                                            value="{{ $sharedList->permission_level }}">
                                                                        {{ $permissionLevel->title }}
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $permissionLevel->id }}">{{ $permissionLevel->title }}</option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <option value="0" selected>Нет доступа</option>
                                                            @foreach($permissionLevels as $permissionLevel)
                                                                <option value="{{ $permissionLevel->id }}">{{ $permissionLevel->title }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                @endif
                                            @endforeach
                                        </form>

                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <div>
                                            <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Закрыть</button>
                                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" onclick="saveSharedList({{ $list->id }})">Сохранить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-body">

                    <div class="mb-3">{{ $list->description }}</div>

                    <div id="itemList">
                        @foreach($listItems as $item)
                            <div class="p-1 border-secondary border my-2 rounded-3 d-flex
                            justify-content-between align-items-center hoverDiv" id="item{{ $item->id }}">

                                <div class="d-flex align-items-center">
                                    <div class="d-inline-block ms-2" style="width: 40px; height: 40px;">

                                        <a href="{{ URL::asset('/storage/' . $item->preview_image) }}" target="_blank">
                                            <img src="{{ URL::asset('/storage/' . $item->preview_image) }}" alt="" class="w-100 h-100" id="imageItem{{ $item->id }}">
                                        </a>

                                    </div>
                                    <div class="mx-2">
                                        <p class="m-0 p-0" id="titleItem{{ $item->id }}">{{ $item->title }}
                                            @foreach($item->tags as $tag)
                                                <span class="alert alert-warning px-2 py-0 me-1">{{ $tag->title }}</span>
                                            @endforeach</p>
                                        <p class="text-secondary m-0 p-0" id="descriptionItem{{ $item->id }}">{{ $item->description }}</p>
                                        <div class="my-2">
                                        </div>
                                    </div>
                                </div>

                                <div class="mx-2">
                                    @can('update', [$list])
                                        <a type="button" class="text-secondary mx-3" data-bs-toggle="modal" data-bs-target="#modalItem{{ $item->id }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('check', [$list])
                                        @if($item->checked)
                                            <button onclick="checkItem({{ $item->id }})" id="checkButton{{ $item->id }}" class="rounded-3 btn-sm btn btn-dark"><i class="fas fa-check"></i></button>
                                        @else
                                            <button onclick="checkItem({{ $item->id }})" id="checkButton{{ $item->id }}" class="rounded-3 btn-sm btn btn-outline-dark text-white"><i class="fas fa-check"></i></button>
                                        @endif
                                    @endcan
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
                                                <input type="text" id="descriptionInputItem{{ $item->id }}" class="form-control mb-2" value="{{ $item->description }}">

                                                <p class="m-0">Изображение</p>
                                                <form enctype="multipart/form-data" method="post" action="" class="d-flex flex-column">
                                                    @csrf
                                                    @method('patch')
                                                    <input class="mb-2" type="file" name="inputImageItem{{ $item->id }}" accept=".jpg, .jpeg, .png" id="imageInput{{ $item->id }}">
                                                </form>

                                                <div class="form-group mt-2">
                                                    <select name="tags[]" class="tags" id="tagsItem{{ $item->id }}" multiple="multiple" data-placeholder="Добавить тег" style="height: 300px; width: 100%;">
                                                        @forelse($tags as $tag)
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
                                                        @empty
                                                            <option disabled>У вас нету тегов. Чтобы добавить тег, зайдите в раздел "теги"</option>
                                                        @endforelse
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

                        @can('update', [$list])
                            <div class="p-1 border-opacity-25 border-secondary border mt-2 p-2 rounded-3 d-flex flex-column" id="newItem">
                                @if ($errors->has('title'))
                                    <div class="alert alert-danger w-100">
                                        @foreach($errors->get('title') as $message){{$message}}<br>@endforeach
                                    </div>
                                @endif
                                <form action="{{ route('item.store', ['list' => $list]) }}" method="post">
                                    @csrf
                                    @method('post')
                                    <input type="text" class="form-control mb-2" name="title" placeholder="Название">
                                    <textarea type="text" class="form-control mb-2" name="description" placeholder="Описание"></textarea>
                                    <button class="btn btn-success">Добавить</button>
                                </form>
                            </div>
                        @endcan
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
