<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
    <title>Document</title>
</head>

<body class=" bg-light">


    <div class="container ">




        <div class="row mt-3 mx-auto" style="max-width:300px">
            <div class="col-md-12">
                <div class="card border-dark" id="card-preview">
                    <video class="bg-dark card-img-top rounded-top" id="preview" width="100%" height="205" autoplay=""
                        muted=""></video>
                    <div class="card-body">
                        <h5 class="card-title">Preview</h5>
                        <p class="card-text small">Here will be the live stream of webcam once clicked on start
                            recording</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div id="card-footage" class="card  border-dark d-none">
                    <video class="bg-dark  rounded-top" id="recording" width="100%" height="205" controls=""></video>
                    <div class="card-body">
                        <h5 class="card-title">Footage</h5>
                        <p class="card-text small">Here will be the recorded foodtage result after clicking stop record
                        </p>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
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
            </div>

        </div>


        <div class="text-center mt-3 ">


            <div class="btn-group " role="group" aria-label="Basic example">
                <button id="startButton"  type="button" class="btn btn-outline-dark">Start </button>
                <button id="stopButton" type="button" class="btn btn-outline-dark disabled">Stop</button>
              </div>

 


             <button  class="btn btn-outline-dark my-3" data-url="{{ url('store') }}" id="upload">
                Upload video <i class="bi bi-cloud-arrow-up-fill"></i>
            </button>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        let preview = document.getElementById("preview");
        let recording = document.getElementById("recording");
        let startButton = document.getElementById("startButton");
        let stopButton = document.getElementById("stopButton");
        let card_footage = document.getElementById("card-footage");
        let card_preview = document.getElementById("card-preview");

        var formData = new FormData();

        let recordingTimeMS = 5000;



        function wait(delayInMS) {
            return new Promise(resolve => setTimeout(resolve, delayInMS));
        }

        function startRecording(stream, lengthInMS) {
            let recorder = new MediaRecorder(stream);
            let data = [];

            recorder.ondataavailable = event => data.push(event.data);
            recorder.start();

            let stopped = new Promise((resolve, reject) => {
                recorder.onstop = resolve;
                recorder.onerror = event => reject(event.name);
            });

            let recorded = wait(lengthInMS).then(
                () => recorder.state == "recording" && recorder.stop()
            );
            return Promise.all([
                    stopped,
                    recorded
                ])
                .then(() => data);
        }

        function stop(stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        startButton.addEventListener("click", function() {

            card_preview.classList.add("d-block");
            card_preview.classList.remove("d-none");
            stopButton.classList.remove("disabled");
            startButton.classList.add("disabled");
            card_footage.classList.add("d-none");
            card_footage.classList.remove("d-block");

            navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                }).then(stream => {
                    preview.srcObject = stream;
                    preview.captureStream = preview.captureStream || preview.mozCaptureStream;
                    return new Promise(resolve => preview.onplaying = resolve);
                }).then(() => startRecording(preview.captureStream(), recordingTimeMS))
                .then(recordedChunks => {
                    let recordedBlob = new Blob(recordedChunks, {
                        type: "video/webm"
                    });
                    recording.src = URL.createObjectURL(recordedBlob);
                     formData.append('video', recordedBlob);
                }).catch(log) 


            function log(msg) {
                    alert(msg);
                    return;
            }

        }, false);
        stopButton.addEventListener("click", function() {
            card_footage.classList.add("d-block");
            card_footage.classList.remove("d-none");
            card_preview.classList.add("d-none");
            stop(preview.srcObject);
        }, false);


        let upload = document.getElementById("upload");
        if (upload) {
            upload.addEventListener("click", function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: this.getAttribute('data-url'),
                    method: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (data, text) {
                        // location.reload();
                        // console.log("done");
                        window.location.replace(this.getAttribute('data-url'));
                    },
                    error: function (request, status, error) {
                        alert(request.responseText);
                    }
                    });
            }, false);
        };

    </script>


</body>

</html>
