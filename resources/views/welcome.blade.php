<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>
</head>

<body>


  

    <div class="left">
        <div id="startButton" class="button">
            Start
        </div>
        <h2>Preview</h2>
        <video id="preview" width="160" height="120" autoplay="" muted=""></video>
    </div>

    <div class="right">
        <div id="stopButton" class="button">
            Stop
        </div>
        <h2>Recording</h2>
        <video id="recording" width="160" height="120" controls=""></video>
        <a id="downloadButton" class="button">
            Download
        </a>
    </div>

    <div class="bottom">
        <pre id="log"></pre>
    </div>

    <button class="btn btn-dark my-3" data-url="{{url('store')}}" id="upload">
        Upload video
    </button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script>
        let preview = document.getElementById("preview");
        let recording = document.getElementById("recording");
        let startButton = document.getElementById("startButton");
        let stopButton = document.getElementById("stopButton");
        let downloadButton = document.getElementById("downloadButton");
        let logElement = document.getElementById("log");
        var formData = new FormData();

        let recordingTimeMS = 5000;

        function log(msg) {
            logElement.innerHTML += msg + "\n";
        }

        function wait(delayInMS) {
            return new Promise(resolve => setTimeout(resolve, delayInMS));
        }

        function startRecording(stream, lengthInMS) {
            let recorder = new MediaRecorder(stream);
            let data = [];

            recorder.ondataavailable = event => data.push(event.data);
            recorder.start();
            log(recorder.state + " for " + (lengthInMS / 1000) + " seconds...");

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
            navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                }).then(stream => {
                    preview.srcObject = stream;
                    downloadButton.href = stream;
                    preview.captureStream = preview.captureStream || preview.mozCaptureStream;
                    return new Promise(resolve => preview.onplaying = resolve);
                }).then(() => startRecording(preview.captureStream(), recordingTimeMS))
                .then(recordedChunks => {
                    let recordedBlob = new Blob(recordedChunks, {
                        type: "video/webm"
                    });
                    recording.src = URL.createObjectURL(recordedBlob);
                    downloadButton.href = recording.src;
                    downloadButton.download = "RecordedVideo.webm";

                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    formData.append('video', recordedBlob);

                    log("Successfully recorded " + recordedBlob.size + " bytes of " +
                        recordedBlob.type + " media.");
                })
                .catch(log);
        }, false);
        stopButton.addEventListener("click", function() {
            stop(preview.srcObject);
        }, false);




        
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
        };
    </script>


</body>

</html>
