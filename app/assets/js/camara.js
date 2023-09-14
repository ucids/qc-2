const videoElement = document.getElementById('camera-feed');
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        videoElement.srcObject = stream;
    })
    .catch(error => {
        console.error('Error accessing camera:', error);
    });

const captureEmpaqueButton = document.getElementById('capture-empaque-btn');
const captureSmallPartsButton = document.getElementById('capture-small-parts-btn');
const empaqueCanvas = document.getElementById('empaque-canvas');
const smallPartsCanvas = document.getElementById('small-parts-canvas');
const capturedEmpaquePhoto = document.getElementById('captured-empaque-photo');
const capturedSmallPartsPhoto = document.getElementById('captured-small-parts-photo');
const trackingNumberInput = document.getElementById('tracking-number');
const submitButton = document.getElementById('submit-btn');
const successMessage = document.getElementById('success-message');
const messageContainer = document.getElementById('message-container');
const errorMessageElement = document.getElementById('error-message');

let empaquePhotoData = null;
let smallPartsPhotoData = null;

captureEmpaqueButton.addEventListener('click', () => {
    empaqueCanvas.width = videoElement.videoWidth;
    empaqueCanvas.height = videoElement.videoHeight;
    empaqueCanvas.getContext('2d').drawImage(videoElement, 0, 0, empaqueCanvas.width, empaqueCanvas.height);
    capturedEmpaquePhoto.src = empaqueCanvas.toDataURL('image/png');
    capturedEmpaquePhoto.style.display = 'block';
    empaquePhotoData = capturedEmpaquePhoto.src;
});

captureSmallPartsButton.addEventListener('click', () => {
    smallPartsCanvas.width = videoElement.videoWidth;
    smallPartsCanvas.height = videoElement.videoHeight;
    smallPartsCanvas.getContext('2d').drawImage(videoElement, 0, 0, smallPartsCanvas.width, smallPartsCanvas.height);
    capturedSmallPartsPhoto.src = smallPartsCanvas.toDataURL('image/png');
    capturedSmallPartsPhoto.style.display = 'block';
    smallPartsPhotoData = capturedSmallPartsPhoto.src;
});

submitButton.addEventListener('click', () => {
    const trackingNumber = trackingNumberInput.value.trim();

    if (trackingNumber === '') {
        errorMessageElement.textContent = 'Tracking number es requerido.';
        return;
    }

    if (!empaquePhotoData || !smallPartsPhotoData) {
        errorMessageElement.textContent = 'Ambas fotos son requeridas.';
        return;
    }

    errorMessageElement.textContent = ''; // Clear any previous error messages

    const formData = new FormData();
    formData.append('tracking-number', trackingNumber);
    formData.append('empaque-image-data', empaquePhotoData);
    formData.append('small-parts-image-data', smallPartsPhotoData);

    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            // Handle different HTTP status codes here
            if (response.status === 400) {
                console.error('Bad request: Missing data.');
            } else if (response.status === 500) {
                console.error('Server error: ' + response.statusText);
            } else {
                console.error('Unexpected error: ' + response.statusText);
            }
            throw new Error('Upload failed.');
        }
        return response.text();
    })
    .then(result => {
        console.log(result);
        showSuccessMessage();
        resetPhotos();
    })
    .catch(error => {
        console.error('Error sending photos:', error);
        // Handle the error and display a message as needed
    });
});

function showSuccessMessage() {
    const successMessageDiv = document.createElement('div');
    successMessageDiv.textContent = 'El Tracking Number se ha registrado correctamente.';
    successMessageDiv.style.color = 'green';
    successMessageDiv.style.marginTop = '10px';
    successMessageDiv.style.fontSize = '16px';
    successMessageDiv.style.fontWeight = 'bold';

    messageContainer.appendChild(successMessageDiv);

    setTimeout(() => {
        messageContainer.removeChild(successMessageDiv);
    }, 5000);
}

function resetPhotos() {
    capturedEmpaquePhoto.src = '';
    capturedEmpaquePhoto.style.display = 'none';
    capturedSmallPartsPhoto.src = '';
    capturedSmallPartsPhoto.style.display = 'none';
    successMessage.style.display = 'none';
    trackingNumberInput.value = '';

    // Reset the image data variables
    empaquePhotoData = null;
    smallPartsPhotoData = null;
}
