@extends('master')
@section('content')

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
{{ HTML::script('js/event-script.js') }}

<?php $errorImage = asset('images/google404.png'); ?>

@if(isset($event))
<div class="title_wrapper">
    <h3 class="title">Детали за акцијата {{ $event->name }} </h3>
</div>



<div class="profile_wrapper">

        <div class="profile_buttons">

            <a href="../donation/event/{{ $event->id }}/add">
                <div class="metro_button pink profile_button event">
                    <img class="metro_icon" src="../images/adddonationicon.png"/>
                    <p class="button_text">додади дарување</p>
                </div>
            </a>


            <a href="{{ $event->id  }}/edit">
                <div class="metro_button blue profile_button event">
                    <img class="metro_icon" src="../images/editicon.png"/>
                    <p class="button_text">смени податоци</p>
                </div>
            </a>

             <a id="toggle_is_active" href="javascript:;"">
                <div class="metro_button violet profile_button event">
                    @if($event->isactive == 0)
                    <img id="toggle_image" class="metro_icon" src="../images/unlockicon.png"/>
                    <p id="toggle_text"  class="button_text">отвори акција</p>

                    <input name="event_fk" value="{{ $event->id }}" type="text" hidden/>

                    @else

                    <img id="toggle_image" class="metro_icon" src="../images/lockicon.png"/>
                    <p id="toggle_text"  class="button_text">затвори акција</p>

                    @endif

                </div>
            </a>

        </div>

        <div class="clear"></div>

        <div class="profile_info">
            <div class="search_results_wrapper donations ">
                <table class="flat_table flat_table_1 profile_table">
                <thead>
                <th>Град</th>
                <th>Почнува</th>
                <th>Завршува</th>
                <th>Затворена</th>
                </thead>
                <tbody class="search_results">
                <tr>
                    <td>{{ $event->city }}</td>
                    <td>{{ $event->start_time }}</td>
                    <td>{{ $event->end_time }}</td>
                    <td id="toggle_status">
                        @if($event->isactive == 0)
                            {{ 'Да' }}
                        @else
                            {{ 'Не' }}
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
        </div>


        <div class="clear"></div>
    <div class="title_wrapper details">
        <h4 class="title">Резерви на крв на државно ниво - Секторски дијаграм</h4>
    </div>

        <div id="empty_chart" class="outcome"></div>

        <div class="chart_wrapper" id="chart_wrapper">

            <div id="pie_chart" class="chart"></div>
        </div>




        {{ Form::text('event_fk', $event->id, ['hidden' => 'true' ]) }}


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
