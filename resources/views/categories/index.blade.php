@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Категории</div>

                    <div class="panel-body">
                        <div class="wrapper-alert">
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>

                        <a class="btn btn-success btn-sm" href="{{ route('categories.create') }}">Новая категория</a>
                        <table class="table table-hover">
                            <thead>
                                <th>Название</th>
                                <th>Действие</th>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr id="row_{{$category->id}}">
                                        <td><a href="{{route('categories.show', ['id' => $category->id])}}">{{$category->title}}</a></td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" href="{{route('categories.edit', ['id' => $category->id])}}">Редактировать</a>
                                            <button class="btn btn-danger btn-xs remove-js" action="{{route('categories.destroy', ['id' => $category->id])}}" el_id="{{$category->id}}">Удалить</button>
                                            <img src="{{ asset('images/loader.gif') }}" alt="" class="loader"/>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        {{ $categories->links() }}
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