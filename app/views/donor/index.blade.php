@extends('master')

@section('content')

{{ HTML::script('js/users-script.js') }}
<div class="title_wrapper">
<h3 class="title">Листа на крводарители</h3>
</div>
<table class="flat_table flat_table_1">
    <thead>
    <th>Име</th>
    <th>Град</th>
    <th>Крвна група</th>
    <th>Последно дарување</th>
    </thead>
    <tbody class="search_results">

    @foreach ($donors as $donor)

    <tr>
        <td> {{  link_to_route('donor.show', $donor->name, $donor->id ) }} </td>

        <td> {{ $donor->city }} </td>

        <td> {{ $donor->bloodtype }} </td>

        <td> {{ $donor->lastDonation }} </td>

    </tr>

    @endforeach

    </tbody>


</table>

@if(isset($donors))
    {{ $donors->links(); }}
@endif


@stop

