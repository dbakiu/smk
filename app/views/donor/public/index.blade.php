@extends('master')
@section('content')



<div class="profile_wrapper">

    <div class="title_wrapper">
        <h3 class="title">Идни акции</h3>
    </div>
    <div class="search_results_wrapper donations">
        <br/><br/>
        <table class="flat_table flat_table_1">
            <thead>
            <th>#</th>
            <th>Настан</th>
            <th>Град</th>
            <th>Адреса</th>
            <th>Град</th>
            <th>Адреса</th>
            </thead>
            <tbody class="search_results">
            <?php

            $count = 1;

       foreach($events as $event){

            if($count %2 != 0){
                            echo   '<tr class="odd">
                                     <td>' . $count . '</td>
                                     <td>' . '<a class="search_link" href="' . '../event'  . '/' .  $event->id . '">' . $event->name .'</a></td>'
                                . '<td>' . $event->city . '</td>'
                                . '<td>' . $event->address . '</td>'
                                . '<td>' . $event->start_time . '</td>'
                                . '<td>' . $event->end_time . '</td>'
                                . '</tr>';

            }
                else{
                    echo   '<tr class="even">
                                     <td>' . $count . '</td>
                                     <td>' . '<a class="search_link" href="' . '../event'  . '/' .  $event->id . '">' . $event->name .'</a></td>'
                        . '<td>' . $event->city . '</td>'
                        . '<td>' . $event->address . '</td>'
                        . '<td>' . $event->start_time . '</td>'
                        . '<td>' . $event->end_time . '</td>'
                        . '</tr>';

                }





                    $count++;
                }


            ?>
            </tbody>
        </table>


        </form>
        <br/><br/>


    </div>



</div>



@stop
