@extends('master')


@section('content')
@parent
<div class="stats_panel">

         <span class="stats_icon"><img src="images/statsicon.png"/></span>

    <div class="stats_content">

         <p class="stats_title">Број на крводарители</p>
          @if(isset($donors))
         <p class="stats_data">{{ $donors }}</p>

         @endif

         <p class="stats_title">Број на дарувања</p>
         @if(isset($donations))
         <p class="stats_data">{{ $donations }}</p>

         @endif

         <p class="stats_title">Акции во тек</p>
         @if(isset($liveDonationEvents))
         <p class="stats_data">{{ $liveDonationEvents }}</p>


         @endif

         <p class="stats_title">Завршени акции</p>
         @if(isset($finishedDonationEvents))
         <p class="stats_data">{{ $finishedDonationEvents }}</p>

         @endif
    </div>
</div>
<div class="clear"></div>
@stop

@section('content')
<div class="clear"></div>
<div class="homepage_content">

<div class="metro_menu">
    <a href="donor/add">
    <div class="metro_button red">
        <img class="metro_icon" src="images/addusericon.png"/>
        <p class="button_text">додади крводарител</p>
    </div>
    </a>

    <a href="event/add">
    <div class="metro_button yellow">
        <img class="metro_icon" src="images/addeventicon.png"/>
        <p class="button_text">додади акција</p>
    </div>
    </a>


    <a href="notification">
        <div class="metro_button pink">
            <img class="metro_icon" src="images/mailicon.png"/>
            <p class="button_text">испрати известување</p>
        </div>
    </a>


    <a href="donor/search">
    <div class="metro_button blue">
        <img class="metro_icon" src="images/searchusericon.png"/>
        <p class="button_text">најди крводарител</p>
    </div>
    </a>

    <a href="event">
        <div class="metro_button yellower">
            <img class="metro_icon" src="images/eventsicon.png"/>
            <p class="button_text">прегледај акција</p>
        </div>
    </a>

    <a href="reserves">
    <div class="metro_button violet">
        <img class="metro_icon" src="images/barrelicon.png"/>
        <p class="button_text">провери резерви</p>
    </div>
    </a>
</div>
<!--<div class="clear"></div> -->


</div>

@stop
