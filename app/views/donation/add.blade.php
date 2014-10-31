@extends('master')
@section('content')

{{ HTML::script('js/donation-script.js') }}
<?php $errorImage = asset('images/google404.png'); ?>

@if(isset($donorInfo) && $donorInfo != 'empty')

<div class="title_wrapper">
    <h3 class="title">Додавање на дарување</h3>
</div>

<div class="add_donation_wrapper">



 @if($eligibilityInfo['eligible'] == 1)

    <div class="donation_form">


    {{ Form::open(['action' => 'donation.store']) }}


    {{ Form::text('donor_fk', $donorInfo->id, [ 'hidden' => 'false'])  }}

        {{ Form::label('event_fk', 'Акција' )  }}

    <select name="event_fk">

        <?php

       foreach($events as $event){
                echo '<option ';
                echo 'value="' . $event->id . '"';
                echo ">";
                echo $event->name;
                echo '</option>';


        }
        if(isset($donations)){
        foreach($donations as $donation){
            echo '<option ';
            echo 'value="' . $donation->id . '" disabled';
            echo ">";
            echo $donation->name;
            echo '</option>';

        }
        }
        ?>

    </select>
    {{ Form::text('ref', 'donor', ['hidden' => 'true'])  }}
        <br/><br/>
    {{ Form::submit('Додади') }}

    {{ Form::close() }}

     </div>

@else

    <div class="donation_form small hidden" id="donation_form">
    {{ Form::open(['action' => 'donation.store']) }}


    {{ Form::text('donor_fk', $donorInfo->id, [ 'hidden' => 'true'])  }}

        {{ Form::label('event_fk', 'Акција' )  }}

    <select name="event_fk">

        <?php
        $donorsPageLink = link_to_route('donors.index', 'Откажи дарување');
        foreach($events as $event){
            echo '<option ';
            echo 'value="' . $event->id . '"';
            echo ">";
            echo $event->name;
            echo '</option>';


        }
        if(isset($donations)){
            foreach($donations as $donation){
                echo '<option ';
                echo 'value="' . $donation->id . '" disabled';
                echo ">";
                echo $donation->name;
                echo '</option>';

            }
        }
        ?>

    </select>
    {{ Form::text('ref', 'donor', ['hidden' => 'true'])  }}

        <br/><br/>

    {{ Form::submit('Додади') }}

    {{ Form::close() }}
        <br/><br/>
        {{ $donorsPageLink }}
    </div>


    <div class="donation_information" id="donation_information">
    {{ '<b>' . $donorInfo->name . '</b> сè уште не смее да дарува. Последен пат' }}
    @if($donorInfo->gender == '1')
    {{ ' дарувал на ' }}
    @else
    {{ ' дарувала на '}}
    @endif
    {{  $eligibilityInfo['lastDonation'] . ' и треба да поминат уште ' . $eligibilityInfo['timeLeft'] . ' ден/а до следното дарување.' }}
        <a href="#" id="donate_anyway">Сепак додади?</a>
    </div>

@endif


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


