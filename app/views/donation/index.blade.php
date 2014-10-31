@extends('master')


@section('content')
<div class="donation_form">
    <h1>Додавање на донација</h1>

    {{ Form::open() }}


    {{ Form::text('donor_fk', null, [ 'hidden' => 'false'])  }}
    {{ Form::text('event_fk', null, [ 'hidden' => 'false'])  }}


    {{ Form::submit() }}

    {{ Form::close() }}

    {{ URL::action('UserController@show', ['123', '99']); }}
</div>

@stop
