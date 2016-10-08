@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Редактирование заметки</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('notes.update',["id" => $note->id])}}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Название</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="title" value="{{ $note->title }}" required autofocus>

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                <label for="category" class="col-md-4 control-label">Категория</label>

                                <div class="col-md-6">
                                    <select name="category" class="form-control">
                                        <option default value="0">Без категории</option>
                                        @foreach($categories as $category)
                                            @if ($note->category_id == $category->id)
                                            <option selected value="{{ $category->id }}">{{ $category->title }}</option>
                                            @else
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Текст</label>

                                <div class="col-md-6">
                                    <textarea id="text" type="text" class="form-control"  required name="text" value="{{ old('text') }}">{{ $note->text }}</textarea>
                                    @if ($errors->has('text'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Сохранить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
