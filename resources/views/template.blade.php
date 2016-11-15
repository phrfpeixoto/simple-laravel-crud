<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="author" content="Pedro Peixoto">
    <link rel="icon" href="../../favicon.ico">

    <title>Laravel Crud</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('font_awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>

<body>
    @include('partials.navbar')
    <div class="container main-container">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
            </div>
        </div>
        @section('content')
        <div class="row">
            <div class="col-md-12">
                <h1>Content</h1>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
            </div>
        </div>
        <hr />
        <footer>
            <p>Footer</p>
        </footer>
        @show
    </div> <!-- /container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{asset('angular/angular.min.js')}}"></script>
<script src="{{asset('angular/angular-animate.min.js')}}"></script>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/underscore-min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
@section('javascripts')
@show
</body>
</html>