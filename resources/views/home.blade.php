@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Мой профиль</div>

                <div class="panel-body">
                    <p>Привязка социальных аккаунтов</p>
                    <a href="{{ route('social.login',['provider' => 'vkontakte']) }}">Привязать вк</a>
                    {{ $notes_vk }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
