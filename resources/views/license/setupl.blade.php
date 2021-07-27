<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="" content="Cursus">
    <title>Cursus</title>


    <link href="{{ static_asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <style>
        body {
            background: #e9ecef;
        }
    </style>
</head>

<body translate="no" >
    <div class="jumbotron text-center">
        <h1 class="display-3">Thank You!</h1>
        <p class="lead">
            <strong class="d-block">Thanks for purchase Cursus </strong>
            <br>
            <strong class="d-block"><b>Getting Started</b></strong>
            <br>
            get your installation key and install database to <strong>Getting Started. </strong>
        </p>
        <hr>
        <p class="lead">
            <a class="btn btn-primary btn-sm" href="{{url('installer')}}" role="button">Cursus Installer</a>
        </p>
    </div>

</body>

</html>