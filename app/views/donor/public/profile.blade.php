@extends('master')
@section('content')

{{ HTML::script('js/donation-script.js') }}

 @if (!empty($donor) && $donor != 'empty')


<div class="title_wrapper"><h3 class="title">Профилот на {{ $donor->name }} </h3></div>



<div class="profile_wrapper">

    <div class="clear"></div>

    <br/>

    <div class="profile_info">

        <div class="search_results_wrapper donations ">
            <table class="flat_table flat_table_1 profile_table">
                <thead>
                <th>Град</th>
                <th>ЕМБГ</th>
                <th>Крвна група</th>
                <th>E-mail</th>
                <th>Телефон</th>
                </thead>
                <tbody class="search_results">
                <tr>
                    <td> {{ $donor->city }} </td>
                    <td> {{ $donor->emb }} </td>
                    <td> {{ $donor->bloodtype }} </td>
                    <td> {{ $donor->email }} </td>
                    <td> {{ $donor->telephone }} </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


    @if(!$donations->isEmpty())


    <div class="outcome">
    <br/><br/>
        Последен пат дарувавте крв на {{ $eligibilityInfo['lastDonation']   }}.
        @if($eligibilityInfo['timeLeft'])
        {{ 'Треба да поминат уште ' . $eligibilityInfo['timeLeft'] . ' ден/а до следното дарување.' }}
        @endif
    </div>

    <div class="title_wrapper profile">
        <h4 class="title">

            Имате дарувано на овие акции:

        </h4></div>


    <div class="search_results_wrapper donations">
            <table class="flat_table flat_table_1">
                <thead>
                <th>#</th>
                <th>Настан</th>
                <th>Град</th>
                <th>Датум</th>
                </thead>
                <tbody class="search_results">
                 <?php

                      $count = 1;


                      foreach($donations as $donation){



                      foreach($events as $event){

                          if($donation->event_fk == $event->id)
                            if($count %2 != 0){
                                echo   '<tr class="odd">
                                     <td>' . $count . '</td>
                                     <td>' . '<a class="search_link" href="' . '../event'  . '/' .  $event->id . '">' . $event->name .'</a></td>'
                                    . '<td>' . $event->city . '</td>'
                                    . '<td>' . $donation->donationDate . '</td>'
                                    . '</tr>';


                            }
                            else{

                             echo   '<tr class="even">
                                     <td>' . $count . '</td>
                                     <td>' . '<a class="search_link" href="' . '../event'  . '/' .  $event->id . '">' . $event->name .'</a></td>'
                                     . '<td>' . $event->city . '</td>'
                                     . '<td>' . $donation->donationDate . '</td>'
                                     . '</tr>';


                            }


                        }
                          $count++;
                      }
                ?>
                </tbody>
            </table>


        </form>
        <br/><br/>


    </div>

    @else

    <div class="title_wrapper profile">
        <h4 class="title">

            Немате дарувано на ниедна акција и смеете слободно да дарувате.

        </h4></div>

    @endif
</div>

    @else

    <div class="profile_wrapper">

    <div class="not_found">
        <img src="../images/google404.png"/>
        <br/>
        {{ 'Немате доволно пермисии.'; }}
    </div>
    </div>

    @endif



@stop
