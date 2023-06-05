@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <div class="d-flex justify-content-between">
                    <h1 class="fw-bold">Списки задач</h1>
                    <a href="{{ route('list.create') }}" class="btn btn-outline-success btn-sm py-0 d-flex align-items-center">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>

                    <div>
                        <p class="mb-5">
                            На этой странице расположены все ваши списки.
                        </p>

                        @if($accessedLists)
                            <div class="fw-bold border-bottom borde border-black mb-2">Списки, которыми с вами поделились</div>
                        @endif
                        <div class="d-flex justify-content-between border-bottom">
                            <p>Название</p>
                            <p>Выполнено</p>
                        </div>
                        @foreach($accessedLists as $list)
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-2">
                                <div>
                                    <a href="{{ route('list.show', ['list' => $list]) }}">{{ $list->title }}</a>
                                    <div class="alert alert-info d-inline-block mx-2 m-1 p-0 px-1">Список пользователя {{ $list->owner->name }}</div>
                                </div>

                                <span class="text-secondary">
                                    {{ $list->checked_item_count }} / {{ $list->item_count }}
                                    @if($list->checked_item_count == $list->item_count)
                                        <span class="text-success"><i class="fas fa-check"></i></span>
                                    @else
                                        <span class="text-warning"><i class="fas fa-spinner"></i></span>
                                    @endif
                                </span>
                            </div>
                        @endforeach


                        <div class="fw-bold border-bottom borde border-black mb-2 mt-5">Ваши списки</div>
                        <div class="d-flex justify-content-between border-bottom">
                            <p>Название</p>
                            <p>Выполнено</p>
                        </div>
                        @forelse($lists as $list)
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-2">

                                <a href="{{ route('list.show', ['list' => $list]) }}">{{ $list->title }}</a>

                                <span class="text-secondary">
                                    {{ $list->checked_item_count }} / {{ $list->item_count }}
                                    @if($list->checked_item_count == $list->item_count)
                                        <span class="text-success"><i class="fas fa-check"></i></span>
                                    @else
                                        <span class="text-warning"><i class="fas fa-spinner"></i></span>
                                    @endif
                                </span>
                            </div>
                        @empty
                            <p class="text-secondary">У вас еще нету списков, создайте первый!</p>
                        @endforelse

                    </div>

            </div>
        </div>
    </div>
@endsection
