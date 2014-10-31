@extends('master')

@section('content')


<div class="title_wrapper">
    <h3 class="title">Крводарителни акции</h3>
</div>
<table class="flat_table flat_table_1">
    <thead>
    <th>Име</th>
    <th>Град</th>
    <th>Број на дарувања</th>
    <th>Завршена</th>
    </thead>
    <tbody class="search_results">

    @foreach ($events as $event)

    <tr>
        <td> {{  link_to_route('event.show', $event->name, $event->id ) }} </td>

        <td> {{ $event->city }} </td>

        <td class="table_center_content"> {{ $event->donationsCount }} </td>

        <td class="table_center_content">
            @if ($event->isactive == 1)

                {{ 'Не' }}

            @else

                {{ 'Да' }}

            @endif
        </td>

    </tr>

    @endforeach

    </tbody>


</table>

@if(isset($events))
 {{ $events->links(); }}
@endif


@stop