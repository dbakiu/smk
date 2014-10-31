@extends('master')
@section('content')

<div class="title_wrapper">
    <h3 class="title">Додавање на крводарител</h3>
</div>
<div class="add_donor_wrapper">



{{ Form::open(['route' => 'donor.store']) }}

    <ul class="errors">
       @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
      @endforeach
     </ul>
    <div class="add_donor_info">
<div class="personal_info">

         {{ Form::label('name', 'Име и презиме') }} <br />
         {{ Form::text('name', null, ['placeholder' => 'Име и презиме']) }}
         <br />


             {{ Form::label('gender', 'Пол') }} <br />
             {{ Form::select('gender', [
             '1' => 'Машки',
             '0' => 'Женски',
             ]
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
        ]
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
<br />
</div>
<div class="submit_wrapper">
    {{ Form::submit('Додади') }}
</div>

{{ Form::close() }}

</div>

@stop