@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{ route('list.show', ['list' => $list]) }}" class="btn btn-dark btn-sm mb-3">
                    <i class="fas fa-arrow-left"></i>
                    Назад
                </a>

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="fw-bold mt-2">Редактирование {{ $list->title }}</h1>
                    <div class="dropdown cursor-pointer">

                        <form action="{{ route('list.delete', ['list' => $list]) }}" method="post" class="d-inline-block">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger ms-2"><i class="fas fa-trash"></i></button>
                        </form>

                    </div>
                </div>

                <form action="{{ route('list.update', ['list' => $list]) }}" class="d-flex flex-column" method="post">
                    @csrf
                    @method('patch')
                    <input type="text" placeholder="Название" name="title" value="{{ $list->title }}" class="form-control mb-2">
                    <input type="text" placeholder="Описание" name="description" value="{{ $list->description }}" class="form-control mb-2">

                    <button class="btn btn-success">Сохранить</button>
                </form>

            </div>
        </div>
    </div>

@endsection
