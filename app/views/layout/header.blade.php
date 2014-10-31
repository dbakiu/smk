<div class="header">
    <div class="logo_wrapper">

    </div>

    <div class="logout_wrapper">
        <div class="logout_button">
                        @if(Auth::user())
                        <p class="">
                        <span class="username"> Корисник:  {{ Auth::user()->name  }} </span>
                        <form action="{{ URL::to('logout') }}">
                        <input class="logout_submit" type="submit" value="Одјави се">
                        </form>
                        </p>
                        @endif
         </div>
    </div>

    <div class="clear"></div>
    <div class="menu_wrapper">
        <!-- Check if the user is logged in, then check if the user is an admin -->
        @if(Auth::user())
        @if(Auth::user()->isadmin == 1)
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active">{{HTML::linkRoute('index', 'Дома')}}</li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Крводарители<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>{{HTML::linkRoute('donors.index', 'Листа')}}</li>
                                <li class="divider"></li>
                                <li>{{HTML::linkRoute('donor.add', 'Додади крводарител')}}</li>
                                <li class="divider"></li>
                                <li>{{HTML::linkRoute('donor.search', 'Најди крводарител')}}</li>

                                 </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Акции<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>{{HTML::linkRoute('events.index', 'Листа')}}</li>
                                <li class="divider"></li>
                                <li>{{HTML::linkRoute('event.add', 'Додади акција')}}</li>
                            </ul>
                        </li>
                        <li>{{HTML::linkRoute('notification.index', 'Известувања')}}</li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Резерви<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>{{HTML::linkRoute('reserves.index', 'Државни')}}</li>
                                <li class="divider"></li>
                                <li>{{HTML::linkRoute('reserves.cities', 'Локални')}}</li>

                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Корисници<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>{{HTML::linkRoute('users.index', 'Листа')}}</li>
                                <li class="divider"></li>
                                <li>{{HTML::linkRoute('user.create', 'Додади корисник')}}</li>

                            </ul>
                        </li>

                    </ul>

                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>


    @else

        <?php  $profileLink = link_to('profile/' . Auth::user()->id, 'Мојот профил'); ?>

        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">



                        <li class="active">{{ $profileLink }}</li>
                        <li>{{HTML::linkRoute('profile.index', 'Акции')}}</li>



                    </ul>

                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>


        @endif
@endif
        <div class="clear"></div>
    </div>

</div>
