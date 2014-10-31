<?php $errorImage = asset('images/google404.png'); ?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        {{HTML::script('js/jquery-2.1.0.min.js')}}
        {{HTML::script('js/bootstrap.min.js')}}
        {{HTML::style('css/bootstrap.min.css')}}
        {{HTML::style('css/style.css')}}
        <title>Систем за менаџирање на крводарители - СМК</title>
    </head>

    <body>

         <div class="container">
            @include('layout.header')
                   <div class="content">
                       @yield('content')
                   </div>
             <div class="clear"></div>
            @include('layout.footer')

         </div>

    </body>

</html>