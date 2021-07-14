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
        <div class="row mt-5 mx-auto">
            <h1 class="display-5 fw-bold text-center">Welcome to dashboard</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4 text-center">Here you can view all the recorded videos</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="{{ url('/') }}" type="button" class="btn btn-dark px-4 gap-3">Home page</a>
                    <a href="{{ route('auth.logout') }}" type="button" class="btn btn-outline-dark px-4">Logout</a>
                </div>
            </div>
        </div>
        @if(Session::get('success'))
        <div class="alert alert-success  mt-4 mb-3">
            {{Session::get('success')}}
        </div>
        @endif
        @if(Session::get('fail'))
        <div class="alert alert-danger   mt-4 mb-3">
            {{Session::get('fail')}}
        </div>
        @endif
        <div class="row row-cols-1 row-cols-md-3 g-4 bg-light p-5 my-5">
            @foreach($files as $key => $data)
            <div class="col">
                <div class="card rounded-3 shadow-sm mb-5">
                    <video class="card-img-top" controls height="200px" width="320px" src="{{asset('storage/videos/'.$data->path)}}"></video>
                    <div class="card-body">
                        <a class=" btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item')" href="{{ route('video.destroy', ['id' => $data->id]) }}">
                            delete
                        </a>
                    </div>
                    <div class="card-footer bg-white">
                        <p class="card-text small"> <b>Recorded at</b> : {{$data->created_at}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

















</body>

</html>