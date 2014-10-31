@extends('master')

@section('content')
{{ HTML::script('js/login-script.js') }}

<h3 class="main_title">Систем за менаџирање на крводарители</h3>
<div class="login_window">

    <div class="error_message"></div>

    {{ Form::open(['route'=>'sessions.store', 'id' => 'login_form'])}}

    {{ Form::text('name', null, array('placeholder' => 'Корисничко име', 'id' => 'name' )); }}

    <br/>
    {{ Form::password('password', array('placeholder' => 'Лозинка',  'id' => 'password')) }}

    <br/>

    <input type="button" id="submit_btn" value="Најави се" />

{{ Form::close() }}
</div>

@stop

