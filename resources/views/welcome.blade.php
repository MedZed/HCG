<!DOCTYPE html>
<html>

<head>
    <title>Home page</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('bootstrap-5.0.2-dist/css/bootstrap.min.css')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}">


 
</head>

<body>






<div class="container text-center">







    <div class="card rounded-3 shadow-sm mt-5 mx-auto" style="max-width: 30rem;">

        <video class="bg-light rounded-3" class="border-0" autoplay />
    </div>
    
        <button class="btn btn-dark m-3" id="start">
            Start Recording
        </button>
        <button class="btn btn-dark" id="stop" hidden>
            Stop Recording
        </button>
    <button class="btn btn-dark my-3" data-url="{{url('store')}}" id="upload">
        Upload video
    </button>

    <div class=""> Are you an admin? login <a href="{{route('admin.dashboard')}}">here</a> </div>




</div>





    



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        const start = document.getElementById("start");
        const stop = document.getElementById("stop");
        const video = document.querySelector("video");
        let recorder, stream;
        var formData = new FormData();

 

        async function startRecording() {
            stream = await navigator.mediaDevices.getDisplayMedia({
                video: {
                    mediaSource: "screen"
                }
            });
            recorder = new MediaRecorder(stream);
            const chunks = [];
            recorder.ondataavailable = e => chunks.push(e.data);
 
            recorder.onstop = e => {
 
                const completeBlob = new Blob(chunks, {
                    type: chunks[0].type
                });
                video.src = URL.createObjectURL(completeBlob);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                formData.append('video', completeBlob);

            };

            recorder.start();
        }

        start.addEventListener("click", () => {
            start.setAttribute("disabled", true);
            stop.removeAttribute("disabled");

            startRecording();
        });

        stop.addEventListener("click", () => {
            stop.setAttribute("disabled", true);
            start.removeAttribute("disabled");

            recorder.stop();
            stream.getVideoTracks()[0].stop();
        });






        let upload = document.getElementById("upload");


        if (upload) {
            upload.addEventListener("click", function() {
                $.ajax({
                    url: this.getAttribute('data-url'),
                    method: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.success) {
                            location.reload();
                        }
                    }
                });
            }, false);
        }
 
    </script>




</body>


</html>