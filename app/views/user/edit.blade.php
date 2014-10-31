@extends('master')
@section('content')

<?php $errorImage = asset('images/google404.png'); ?>

@if($user != 'empty' && !empty($user))


<div class="title_wrapper">
    <h3 class="title">Промена на податоци за корисник</h3>
</div>

<div class="add_donor_wrapper">

    <ul class="errors">
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul><br/>
    <div class="add_admin_info">
        {{ Form::model($user, [ 'method' => 'PATCH', 'route' => ['user.update', $user->id]]) }}

        {{ Form::label('name', 'Корисничко име') }} <br />
        {{ Form::text('name', null, ['placeholder' => 'Корисничко име'], $user->name) }}
        <br />


        {{ Form::label('email', 'E-mail') }}
        <br />
        {{ Form::text('email', null, ['placeholder' => 'Е-mail'], $user->email) }}

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
<br/>
        {{ Form::submit('Обнови', ['class' => 'update_user']) }}


    {{ Form::close() }}

</div>

@else

<div class="profile_wrapper">

    <div class="not_found">
        <img src="{{ $errorImage }}"/>
        <br/>
        {{ 'Акцијата не постои.'; }}
    </div>
</div>

@endif


@stop








