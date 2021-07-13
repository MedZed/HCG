<!DOCTYPE html>
<html>
<head>
  <title>Home page</title>
 
  <meta name="csrf-token" content="{{ csrf_token() }}">
 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style type="text/css">

 

#start-camera {
    margin-top: 50px;
}

#video {
    display: none;
    margin: 50px auto 0 auto;
}

#start-record, #stop-record, #download-video {
    display: none;
}

#download-video {
    text-align: center;
    margin: 20px 0 0 0;
}

</style>
 
</head>
<body>



<div class="container py-5">




 
<button id="start-camera" class="btn btn-outline-dark">Start Camera</button>
<video id="video" width="320" height="240" autoplay=""></video>
<button id="start-record" class="btn btn-outline-dark">Start Recording</button>
<button id="stop-record" class="btn btn-outline-dark">Stop Recording</button>
<a id="download-video" download="test.webm">Download Video</a>

<script>

let camera_button = document.querySelector("#start-camera");
let video = document.querySelector("#video");
let start_button = document.querySelector("#start-record");
let stop_button = document.querySelector("#stop-record");
let download_link = document.querySelector("#download-video");

let camera_stream = null;
let media_recorder = null;
let blobs_recorded = [];

camera_button.addEventListener('click', async function() {
   	try {
    	camera_stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    }
    catch(error) {
    	alert(error.message);
    	return;
    }

    video.srcObject = camera_stream;
    camera_button.style.display = 'none';
    video.style.display = 'block';
    start_button.style.display = 'block';
});

start_button.addEventListener('click', function() {
    media_recorder = new MediaRecorder(camera_stream, { mimeType: 'video/webm' });

    media_recorder.addEventListener('dataavailable', function(e) {
    	blobs_recorded.push(e.data);
    });

    media_recorder.addEventListener('stop', function() {
    	let video_local = URL.createObjectURL(new Blob(blobs_recorded, { type: 'video/webm' }));
    	download_link.href = video_local;

        stop_button.style.display = 'none';
        download_link.style.display = 'block';
    });

    media_recorder.start(1000);

    start_button.style.display = 'none';
    stop_button.style.display = 'block';
});

stop_button.addEventListener('click', function() {
	media_recorder.stop(); 
});

</script>


</div>

 

 
<div class="container mt-4">
 
  
      <form method="POST" enctype="multipart/form-data" id="upload-file" action="{{ url('store') }}" >
      @csrf   
          <div class="row">
 
              <div class="col-md-12">

                @if(Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif

                  <div class="form-group">
                      <input type="file" name="file" placeholder="Choose file" id="file">
                        @error('file')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                  </div>
              </div>
                 
              <div class="col-md-12">
                  <button type="submit" class="btn btn-primary" id="submit">Upload</button>
              </div>
          </div>     
      </form>
</div>
 
</div>  
</body>