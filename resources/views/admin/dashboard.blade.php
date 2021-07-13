<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('bootstrap-5.0.2-dist/css/bootstrap.min.css')}}">

    <title>Dashboard</title>
</head>

<body>


    <div class="container">
        <div class="row mt-5 mx-auto" style="max-width: 22rem;">
            <div class="col-md-4 col-md-offset-4"></div>
            <h4 class="text-center">Welcome {{$LoggedUserInfo['name']}}</h4>
            <hr>
            <hr>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
            <hr>
            <a href="{{ route('auth.logout') }}">logout</a>
        </div>
    </div>
</body>

</html>