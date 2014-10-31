@extends('master')
@section('content')
{{ HTML::script('js/events-script.js') }}
{{ HTML::script('js/lib/bootstrap-datepicker.js') }}
{{ HTML::script('js/lib/jquery.timepicker.js') }}
{{ HTML::script('js/lib/jquery.datepair.js') }}
{{ HTML::script('js/lib/jquery.ptTimeSelect.js') }}
{{ HTML::style('js/lib/css/jquery.ptTimeSelect.css') }}
{{ HTML::style('js/lib/css/jquery.timepicker.css') }}
{{ HTML::style('js/lib/css/bootstrap-datepicker.css') }}


<div class="title_wrapper">
    <h3 class="title">Додавање на крводарителна акција</h3>
</div>
<div class="add_event_wrapper">

    <ul class="errors">
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>

    {{ Form::open(['route' => 'event.store']) }}

    <div class="add_donor_info">

        <div class="personal_info">

            {{ Form::label('name', 'Име на настан') }} <br />

            {{ Form::text('name', null, [ 'placeholder' => 'Име на настан'])  }}
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
            ]
            ) }}

            <br/>

            {{ Form::label('address', 'Адреса') }}
            <br/>
            {{ Form::text('address', null, ['placeholder' => 'Адреса']) }}
            <br/>


        </div>

    <div class="personal_info">
    <p id="datetimepicker">
        {{ Form::label('start_date', 'Времетраење - од') }} <br/>
        {{ Form::text('start_date', '1/1/2014', array('class' => 'date start', 'id' => 'dateselector', 'readonly')) }}
        {{ Form::text('start_time', '12:00', array('class' => 'time start', 'id' => 'timeselector', )) }}
        <br/>
        {{ Form::label('start_date', 'до') }} <br/>
        {{ Form::text('end_date', '1/1/2014', array('class' => 'date end', 'id' => 'dateselector', 'readonly')) }}
        {{ Form::text('end_time', '13:00', array('class' => 'time end', 'id' => 'timeselector', )) }}



    </p>
        </div>
        <div class="clear"></div>
    </div>
    <div class="submit_wrapper">
        {{ Form::submit('Додади') }}
        <br/>
    </div>

    {{ Form::close() }}

</div>



<script>
    // initialize input widgets first
    $('#datetimepicker .time').timepicker({
        'showDuration': true,
        'timeFormat': 'G:i'
    });

    $('#datetimepicker .date').datepicker({
        'format': 'd/m/yyyy',
        'autoclose': true
    });

    // initialize datepair
    $('#datetimepicker').datepair();
</script>

@stop