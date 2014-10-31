@extends('master')
@section('content')
{{ HTML::script('js/donor-script.js') }}
{{ HTML::script('js/lib/jquery.confirm.js') }}

<?php $errorImage = asset('images/google404.png'); ?>

@if($donor != 'empty' && !empty($donor))


<div class="title_wrapper">
    <h3 class="title">Промена на податоци за крводарител</h3>
</div>


<div class="add_donor_wrapper">
    <br/>
    <div class="outcome" id="outcome"></div>

    <ul class="errors">
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>

    {{ Form::model($donor, ['method' => 'PATCH', 'route' => ['donor.update', $donor->id]]) }}



    <div class="add_donor_info">

        <br/>
        <div class="personal_info">

            {{ Form::label('name', 'Име и презиме') }} <br />
            {{ Form::text('name', null, ['placeholder' => 'Име и презиме']) }}
            <br />


            {{ Form::label('gender', 'Пол') }} <br />
            {{ Form::select('gender', [
            '1' => 'Машки',
            '0' => 'Женски',
            ], $donor->gender
            ) }}

            <br/>
            {{ Form::label('emb', 'ЕМБГ') }} <br />
            {{ Form::text('emb', null, ['placeholder' => 'ЕМБГ']) }}
        </div>

        <div class="personal_info">
            {{ Form::label('city', 'Град') }} <br />
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
            $donor->city
            ) }}
            <br/>
            {{ Form::label('address', 'Адреса') }}
            <br/>
            {{ Form::text('address', null, ['placeholder' => 'Адреса']) }}
            <br/>

            {{ Form::label('bloodtype', 'Крвна група') }}
            <br/>
            {{ Form::select('bloodtype', [
            'A+' => 'A+',
            'A-' => 'A-',
            'B+' => 'B+',
            'AB+' => 'AB+',
            'AB-' => 'AB-',
            'O+' => 'O+',
            'O-' => 'O-'
            ]
            ) }}
        </div>



        <div class="personal_info">

            {{ Form::label('email', 'E-mail') }}
            <br />
            {{ Form::text('email', null, ['placeholder' => 'Е-mail']) }}

            <br />
            {{ Form::label('telephone', 'Контакт телефон') }}
            <br />
            {{ Form::text('telephone', null, ['placeholder' => 'Контакт телефон']) }}
            {{ Form::text('staff_fk', Session::get('staffId'), ['hidden' => 'true']) }}

        </div>
        <div class="personal_info">
    <hr/>
            {{ Form::label('', 'Избриши крводарител') }}
            <br />
            <input type="button" id="delete_donor" value="Избриши"/>
            <br />
            {{ Form::label('', 'Ресетирај лозинка') }}
            <br />
            <input type="button" id="reset_password" value="Ресетирај"/>


            {{ Form::text('donor_fk', $donor->id, ['id' => 'donor_fk', 'hidden' => 'true']) }}

        </div>

        <div class="clear"></div>
        <br/>
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
        {{ 'Крводарителот не постои.'; }}
    </div>
</div>

@endif


@stop








