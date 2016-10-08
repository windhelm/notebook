@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $note->title }}</div>

                    <div class="panel-body">

                        <p>Текст заметки</p>
                        @if($note->text != "")
                        <p>{{ $note->text }}</p>
                            @else
                            <p>нет</p>
                        @endif

                        <a class="btn btn-primary btn-sm" style="display: inline-block;" href="{{route('notes.edit', ['id' => $note->id])}}">Редактировать</a>
                        <form role="form" method="POST" style="display: inline-block;" action="{{route('notes.destroy', ['id' => $note->id])}}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection