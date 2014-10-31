@extends('master')
@section('content')
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
{{ HTML::script('js/event-script.js') }}
{{ HTML::script('js/lib/bootstrap-datepicker.js') }}
{{ HTML::script('js/lib/jquery.confirm.js') }}
{{ HTML::script('js/lib/jquery.timepicker.js') }}
{{ HTML::script('js/lib/jquery.datepair.js') }}
{{ HTML::script('js/lib/jquery.ptTimeSelect.js') }}
{{ HTML::style('js/lib/css/jquery.ptTimeSelect.css') }}
{{ HTML::style('js/lib/css/jquery.timepicker.css') }}
{{ HTML::style('js/lib/css/bootstrap-datepicker.css') }}

<?php $errorImage = asset('images/google404.png'); ?>


@if($event != 'empty' && !empty($event))

<div class="title_wrapper">
    <h3 class="title">Промена на крводарителна акција</h3>
</div>
<div class="add_event_wrapper">
    <div class="outcome" id="outcome"></div>

    <ul class="errors">
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>

    <div class="outcome">
        <?php
            $dateError = Session::get('dateError', '');
            Session::forget('dateError');
        ?>
        {{ $dateError }}
        <br/>
    </div>

    {{ Form::model($event, ['method' => 'PATCH', 'route' => ['event.update', $event->id]]) }}

    <div class="add_donor_info">

        <div class="personal_info">

            {{ Form::label('name', 'Име на настан') }} <br />

            {{ Form::text('name', null, [ 'placeholder' => 'Име на настан', 'id' => 'event_name'])  }}
        </div>
        <div class="personal_info" >

            {{ Form::label('city', 'Град') }}
            <br />

            {{ Form::select('city', [
            'Скопје' => 'Скопје',
            'Берово' => 'Берово',
            'Битола' => 'Битола',
            'Богданци' => 'Богданци',
            'Валандово' => 'Валандово',
            'Велес' => 'Велес',
            'Виница' => 'Виница',
            'Гевгелија' => 'Гевгелија',
            'Гостивар' => 'Гостивар',
            'Дебар' => 'Дебар',
            'Делчево' => 'Делчево',
            'Демир Капија' => 'Демир Капија',
            'Демир Хисар' => 'Демир Хисар',
            'Кавадарци' => 'Кавадарци',
            'Кичево' => 'Кичево',
            'Кочани' => 'Кочани',
            'Кратово' => 'Кратово',
            'Крива Паланка' => 'Крива Паланка',
            'Крушево' => 'Крушево',
            'Куманово' => 'Куманово',
            'Македонска Каменица' => 'Македонска Каменица',
            'Македонски Брод' => 'Македонски Брод',
            'Неготино' => 'Неготино',
            'Охрид' => 'Охрид',
            'Пехчево' => 'Пехчево',
            'Прилеп' => 'Прилеп',
            'Пробиштип' => 'Пробиштип',
            'Радовиш' => 'Радовиш',
            'Ресен' => 'Ресен',
            'Свети Николе' => 'Свети Николе',
            'Струга' => 'Струга',
            'Струмица' => 'Струмица',
            'Тетово' => 'Тетово',
            'Штип' => 'Штип'
            ],
            $event->city) }}

            <br/>

            {{ Form::label('address', 'Адреса') }}
            <br/>
            {{ Form::text('address', null, ['placeholder' => 'Адреса']) }}
            <br/>


        </div>

        <div class="personal_info">
            <p id="datetimepicker">
                {{ Form::label('start_date', 'Времетраење - од') }} <br/>
                {{ Form::text('start_date', $event->startDate, array('class' => 'date start', 'id' => 'dateselector', 'readonly')) }}
                {{ Form::text('start_time', $event->startTime, array('class' => 'time start', 'id' => 'timeselector', )) }}
                <br/>
                {{ Form::label('start_date', 'до') }} <br/>
                {{ Form::text('end_date', $event->endDate, array('class' => 'date end', 'id' => 'dateselector', 'readonly')) }}
                {{ Form::text('end_time', $event->endTime, array('class' => 'time end', 'id' => 'timeselector', )) }}

        <hr/>
            {{ Form::text('event_fk', $event->id, ['id' => 'event_fk', 'hidden' => 'true']) }}
            {{ Form::label('', 'Избриши акција') }}
            <br />
            <input type="button" id="delete_event" value="Избриши"/>

            </p>
        </div>
        <div class="clear"></div>
    </div>
    <div class="submit_wrapper">
        <br/>
        {{ Form::submit('Обнови') }}
    </div>

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

<script>
    // initialize input widgets first
    $('#datetimepicker .time').timepicker({
        'showDuration': true,
        'timeFormat': 'G:i',
        'defaultTimeDelta': 18000000
    });

    $('#datetimepicker .date').datepicker({
        'format': 'd/m/yyyy',
        'autoclose': true
    });

    // initialize datepair
    $('#datetimepicker').datepair();
</script>

@stop