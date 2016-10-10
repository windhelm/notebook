@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="wrapper-alert">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                <div class="panel-heading">Мой профиль</div>

                <div class="panel-body">


                    <p>Привязка социальных аккаунтов</p>
                    @if (\Auth::user()->check_social())
                        <a href="#">Открепить вк</a>
                        @else
                    <a href="{{ route('social.login',['provider' => 'vkontakte']) }}">Привязать вк</a>
                        @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
