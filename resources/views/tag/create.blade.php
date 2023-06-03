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
                    <h1 class="fw-bold mt-2">Создание тега</h1>
                </div>

                <form action="{{ route('tag.store') }}" class="d-flex flex-column" method="post">
                    @csrf
                    @method('post')
                    <input type="text" placeholder="Название" name="title" class="form-control mb-2">
                    <button class="btn btn-success">Создать</button>
                </form>

            </div>
        </div>
    </div>

@endsection
