@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{ route('tag.index') }}" class="btn btn-dark btn-sm mb-3">
                    <i class="fas fa-arrow-left"></i>
                    Назад
                </a>

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="fw-bold mt-2">Редактирование тега {{ $tag->title }}</h1>
                    <div class="dropdown cursor-pointer">

                        <form action="{{ route('tag.delete', ['tag' => $tag]) }}" method="post" class="d-inline-block">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger ms-2"><i class="fas fa-trash"></i></button>
                        </form>

                    </div>
                </div>

                <form action="{{ route('tag.update', ['tag' => $tag]) }}" class="d-flex flex-column" method="post">
                    @csrf
                    @method('patch')
                    <input type="text" placeholder="Название" name="title" value="{{ $tag->title }}" class="form-control mb-2">
                    <button class="btn btn-success">Сохранить</button>
                </form>

            </div>
        </div>
    </div>

@endsection
