@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Заметки</div>

                    <div class="panel-body">
                        <div class="wrapper-alert">
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>

                        <a class="btn btn-success btn-sm" href="{{ route('notes.create') }}">Новая заметка</a>
                        <table class="table">
                            <thead>
                                <th>Категория</th>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr >
                                        <td>
                                            <a style="font-size:16px; font-weight:700; display: inline-block; margin-bottom:25px;" href="{{route('categories.show', ['id' => $category->id])}}">{{$category->title}}</a>
                                            <table class="table">
                                            @forelse($category->notes as $note)
                                                <tr id="row_{{$note->id}}">
                                                    <td>
                                                        <a href="{{route('notes.show', ['id' => $note->id])}}">{{ $note->title }}</a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary btn-xs" href="{{route('notes.edit', ['id' => $note->id])}}">Редактировать</a>
                                                        <button class="btn btn-danger btn-xs remove-js" action="{{route('notes.destroy', ['id' => $note->id])}}" el_id="{{$note->id}}">Удалить</button>
                                                        <img src="{{ asset('images/loader.gif') }}" alt="" class="loader"/>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td>В категории еще нет заметок</td>
                                                </tr>
                                                @endforelse
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        <a style="font-size:16px; font-weight:700; display: inline-block; margin-bottom:25px;" href="#">Без категории</a>
                                        <table class="table">
                                            @forelse($notes_uncategory as $note)
                                                <tr id="row_{{$note->id}}">
                                                    <td>
                                                        <a href="{{route('notes.show', ['id' => $note->id])}}">{{ $note->title }}</a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary btn-xs" href="{{route('notes.edit', ['id' => $note->id])}}">Редактировать</a>
                                                        <button class="btn btn-danger btn-xs remove-js" action="{{route('notes.destroy', ['id' => $note->id])}}" el_id="{{$note->id}}">Удалить</button>
                                                        <img src="{{ asset('images/loader.gif') }}" alt="" class="loader"/>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>В категории еще нет заметок</td>
                                                </tr>
                                            @endforelse
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        @if ($notes_vk->response == "noacc")
                            <p>Соц аккаунт не привязан</p>
                            @else

                            @if ($notes_vk->response->count > 0)
                                <p>Количество заметок {{ $notes_vk->response->count }}</p>
                                @foreach ($notes_vk->response->items as $note)
                                    @endforeach
                                @else
                                <p>Заметок нет</p>
                                @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-success alert-dismissible" style="display: none;" id="alert-delete-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Запись успешно удалена!
    </div>
@endsection