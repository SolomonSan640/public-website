<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
         <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            html, body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                font-family: 'Inter', sans-serif;
            }
            .wrapper{
                display:flex;
                justify-content:center;
                align-items:center;
                flex-direction:column;
                height:100vh
            }

            img{
                height:auto;
                width: 18vw;
            }

            h3{
                font-size:2vw;
                margin-top: 30px;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="wrapper">
            <img src="{{ asset('images/freshmoeLogo.png') }}" alt="freshmoe.com logo"/>
            <h3>API Server</h3>
        </div>
    </body>
</html>
