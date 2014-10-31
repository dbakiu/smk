@extends('master')

@section('content')

{{ HTML::script('js/users-script.js') }}


<div class="title_wrapper">
<h3 class="title">Листа на корисници</h3>
</div>

    <table class="flat_table flat_table_1">
        <thead>
        <th>Корисничко име</th>
        <th>E-mail</th>
        <th>Додал/а</th>
        </thead>
        <tbody class="search_results">

        @foreach ($users as $user)

        <tr>
            <td> {{  link_to_route('user.show', $user->name, $user->id ) }} </td>

            <td> {{ $user->email }} </td>

            <td>
                @if ($user->donorsAdded == 1)
                    {{ $user->donorsAdded . '     крводарител'}}

                @else
                    {{ $user->donorsAdded . '     крводарители'}}
                @endif
            </td>
        </tr>

        @endforeach

        </tbody>


    </table>


    @if(isset($donors))
    {{ $donors->links(); }}
    @endif



@stop
