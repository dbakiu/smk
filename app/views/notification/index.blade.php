@extends('master')
@section('content')
{{ HTML::script('js/notification-script.js') }}

<div class="title_wrapper">
    <h3 class="title">Испрати известување</h3>
</div>

<div class="message_composer_wrapper" id="message_composer_wrapper">
    <br/>
    <div class="outcome" id="outcome"></div>
    <br/>

<div class="message_composer hidden" id="message_composer">
    {{ Form::label('message_title', 'Наслов') }}
    <br/>
    {{ Form::text('message_title', null, ['id' => 'message_title', 'placeholder' => 'Наслов...']) }}
    <br/>
    {{ Form::label('message_body', 'Содржина') }}
    <br/>
    {{ Form::textarea('message_body', null, ['id' => 'message_body', 'placeholder' => 'Содржина...']) }}
    <br/>
    <br/>

    {{ Form::text('donors_list', null, ['id' => 'donors_list', 'hidden' => 'true']) }}

    <input type="button" id="send_message" value="Испрати порака"/>

</div>
    <div class="clear"></div>

    <input type="button" id="compose_message" value="Нова порака"/>
    <input type="button" id="cancel_message" class="cancel_message" value="Откажи"/>

</div>



<div class="search_form">

    <div class="title_wrapper">
        <h4 class="title">Пребарај крводарител</h4>
    </div>

    {{ Form::open(['route'=>'donor/display', 'id' => 'search_form', 'onsubmit' => 'return false;'])}}

    {{ Form::text('keyword', null, ['placeholder' => 'Клучен збор', 'class' => 'search_bar'] ) }}
    <br /><br />


    {{ Form::label('searchBy', 'Критериум') }}

    <select name="searchBy" id="searchBy" class="search_criteria">
        <option value="name">Име</option>
        <option value="dob">ЕМБГ</option>
        <option value="city">Град</option>
        <option value="bloodtype">Крвна група</option>
        <option value="citybloodtype">Град и крвна група</option>
        <option value="real_user_id">Сериски број на корисник</option>
    </select>

    {{ Form::label('bloodType', 'Крвна група:', ['class' => 'select_bloodtype search_criteria']) }}
    <select name="bloodType" id="selectBloodtype" class="select_bloodtype search_criteria">
        <option value="ALL"">Сите крвни групи</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select>
    {{ Form::label('selectCity', 'Град:', ['class' => 'select_bloodtype search_criteria']) }}
    {{ Form::select('selectCity', [
    'ALL' => 'Сите градови',
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
    ], null, ['class' => 'select_bloodtype search_criteria', 'id' => 'selectCity']
    ) }}


    <br/>
    <br />
    <input type="button" id="submit_btn" value="Пребарај" />
    {{ Form::close() }}

</div>
<br/>
<div class="no_results" id="no_results"></div>

<div class="search_results_wrapper">
    <form name="type">
        <table class="flat_table flat_table_1">
            <thead>
            <th>#</th>
            <th>Име</th>
            <th>Град</th>
            <th>Крвна група</th>
            <th>Последно дарување</th>
            <th>Елигибилен</th>
            <th><input type="checkbox" id="select_all"/></th>
            </thead>
            <tbody class="search_results">

            </tbody>

        </table>
    </form>


</div>



@stop
