@extends('master')
@section('content')




<div class="title_wrapper">
    <h3 class="title">Додавање на крводарител</h3>
</div>
<div class="add_admin_wrapper">


    <ul class="errors">
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>
    <br/>
    <div class="add_admin_info">
    {{ Form::open(['route' => 'user.store']) }}

        {{ Form::label('name', 'Корисничко име') }} <br />
        {{ Form::text('name', null, ['placeholder' => 'Корисничко име']) }}
        <br />


        {{ Form::label('email', 'E-mail') }}
        <br />
        {{ Form::text('email', null, ['placeholder' => 'Е-mail']) }}

        <br />
        {{ Form::label('password', 'Лозинка') }}
        <br />
        {{ Form::password('password', null, ['placeholder' => 'Лозинка']) }}

        <br />
        {{ Form::label('passwordConfirmation', 'Потврда за лозинка') }}
        <br />
        {{ Form::password('passwordConfirmation', null, ['placeholder' => 'Лозинка']) }}


    </div>


    <div class="clear"></div>
    <div class="submit_wrapper">
        <br/>
        {{ Form::submit('Додади', ['class' => 'add_user_submit']) }}
    </div>

    {{ Form::close() }}
</div>


@stop