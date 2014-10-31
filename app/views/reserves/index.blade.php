@extends('master')

@section('content')


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
{{ HTML::script('js/reserves-script.js') }}

<div class="clear"></div>
<div class="chart_wrapper">
    <div class="title_wrapper"><h4>Резерви на крв на државно ниво - Столбест дијаграм</h4></div>
    <div id="column_chart" class="chart"></div>
    <div class="title_wrapper"><h4>Резерви на крв на државно ниво - Секторски дијаграм</h4></div>
    <div id="pie_chart" class="chart"></div>
    <div class="title_wrapper"><h4>Распределба на крводарители по градови</h4><br/></div>
    <div id="geo_chart" class="chart geo"></div>
    <br/>
</div>



@stop
