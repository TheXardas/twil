<!DOCTYPE html>
<html>
    <head>
        <title>Better call us!</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    </head>
    <body>

    <script type="text/javascript">
        window.countries = [];
        @foreach($countries as $country)
            window.countries.push(<?php echo json_encode($country) ?>);
        @endforeach
    </script>
        <div class="container">
            <div class="content">
                <div id="app"></div>
                <script src="{{ asset('js/bundle.js') }}"></script>
            </div>
        </div>
    </body>
</html>
