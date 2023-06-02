@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                    <h1 class="fw-bold mb-5">Списки</h1>

                    <div>

                        @foreach($lists as $list)
                            <div class="d-flex justify-content-between border-bottom mb-2">
                                <a href="{{ route('list.show', ['list' => $list]) }}">{{ $list->title }}</a>
                                <span class="text-secondary">{{ $list->checked_item_count }} / {{ $list->item_count }} задач</span>
                            </div>
                        @endforeach

                    </div>

            </div>
        </div>
    </div>
@endsection
