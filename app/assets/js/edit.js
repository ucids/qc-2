let imagesToUpdate = {};

function openCamera(imgType) {
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        let video = document.createElement('video');
        video.srcObject = stream;
        video.play();

        document.body.appendChild(video);

        let takePhotoBtn = document.createElement('button');
        takePhotoBtn.innerHTML = 'Tomar foto';
        takePhotoBtn.onclick = function() {
            let canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            let ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0);

            imagesToUpdate[imgType] = canvas.toDataURL('image/png');

            document.getElementById(imgType + 'Image').src = imagesToUpdate[imgType];

            stream.getTracks()[0].stop();
            video.remove();
            takePhotoBtn.remove();
        }

        document.body.appendChild(takePhotoBtn);
    });
}

function sendImagesToServer() {
    let formData = new FormData();
    for(let [key, value] of Object.entries(imagesToUpdate)) {
        formData.append(key, value);
    }
    formData.append("tracking", "<?php echo $tracking; ?>");

    fetch('edit_img.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert("Las imágenes se guardaron correctamente.");
        } else {
            alert("Error: " + data.error);
        }
    });
}
