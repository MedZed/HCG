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
    <h4>Welcome {{$LoggedUserInfo['name']}}</h4>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
    <a href="{{ route('auth.logout') }}">logout</a>
</body>
</html>