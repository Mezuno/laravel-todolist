@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <div class="d-flex justify-content-between">
                    <h1 class="fw-bold">Теги</h1>
                    <a href="{{ route('tag.create') }}" class="btn btn-outline-success btn-sm py-0 d-flex align-items-center">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>

                <div>

                    <p class="mb-5">Добавленные на этой странице теги можно использовать для тегирования элементов списков.</p>

                    @forelse($tags as $tag)
                        <div class="d-flex justify-content-between border-bottom mb-2">
                            <p>{{ $tag->title }}</p>
                            <div>
                                <a href="{{ route('tag.edit', ['tag' => $tag]) }}" class="btn btn-outline-primary btn-sm mx-2"><i class="fas fa-pen"></i></a>
                                <form action="{{ route('tag.delete', ['tag' => $tag]) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-secondary">У вас еще нету тегов, создайте первый!</p>
                    @endforelse

                </div>

            </div>
        </div>
    </div>
@endsection
