<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('bootstrap-5.0.2-dist/css/bootstrap.min.css')}}">
    <title>Login</title>
</head>
<body>



<div class="container">

<div class="row mt-5 mx-auto" style="max-width: 22rem;">

<div class="col-md-4 col-md-offset-4 mt-5 pt-5"></div>
<h4 class="text-center">Sign in</h4>  

<form action="{{ route('auth.check') }}" method="post">
@csrf

<div class="form-group">
    @if(Session::get('fail'))
<div class="alert alert-danger">
    {{Session::get('fail')}}
</div>
    @endif
    <labe>Email</label>
    <input type="text" name="email" class="form-control mb-2" id="" placeholder="Enter your email" value="{{ old('email') }}">
    <span class="text-danger">@error('email'){{ $message }} <br> @enderror</span>
    <labe>Password</label>
    <input type="password" name="password" class="form-control mb-2" id="" placeholder="Password">
    <span class="text-danger ">@error('password'){{ $message }} <br> @enderror</span>

    <button type="submit" class="btn btn-dark w-100 my-2">Sign in</button>
</div>

</form>

</div>

</div>

    
</body>
</html>