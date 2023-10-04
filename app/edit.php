<?php
include('class/header.php');

$tracking = $_GET['tracking'] ?? null;
$success = "";
$error = "";

if ($tracking === null) {
    die("No se proporcionó un número de seguimiento.");
}

$query = "SELECT carros.*, users.nombre, users.apellidos, users.username 
FROM carros 
JOIN users ON carros.fk_user = users.id_user 
WHERE carros.tracking= '$tracking'";
$result = mysqli_query($conexion, $query);
$data = mysqli_fetch_assoc($result);

$fecha_creacion = $data['creacion'];
$user_fullname = $data['nombre'] . " " . $data['apellidos'];
$images = [
    'empaque' => $data['empaque'] ?? $defaultPaths['empaque'],
    'parts' => $data['parts'] ?? $defaultPaths['parts']
];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_to_replace'])) {
    $chosenImageKey = $_POST['image_to_replace'];

    if (isset($_POST['image'])) {
        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);

        // Obtenemos la ruta y el nombre de la imagen original
        $existingImage = $images[$chosenImageKey];
        $imageDirectory = pathinfo($existingImage, PATHINFO_DIRNAME);
        $imageName = pathinfo($existingImage, PATHINFO_BASENAME);

        // Construye la ruta del destino
        $fileDestination = $imageDirectory . "/" . $imageName;

        // Verificar si $fileDestination es válido antes de intentar escribir
        if (!empty($imageName) && !empty($fileDestination)) {
            if (file_put_contents($fileDestination, $data)) {
                $success = "Imagen reemplazada con éxito.";
                echo "<script>window.location.href='edit.php?tracking=" . $tracking . "';</script>";
            } else {
                $error = "Ocurrió un error al reemplazar la imagen.";
            }
        } else {
            $error = "Ruta de imagen no válida.";
        }
    }
}

?>

<?php
if ($error) {
    echo '<div style="color: red;">' . $error . '</div>';
}
if ($success) {
    echo '<div style="color: green;">' . $success . '</div>';
}
?>
<div class="app-container container-xxl ">
    <div class="card-body p-lg-5 pb-lg-0">
        <!--begin::Card body-->
        <div class="separator separator-dashed mb-5"></div>
        <div class="mb-17">
            <!--begin::Content-->
            <div class="d-flex flex-stack mb-5">
                <!--begin::Title-->
                <h7 class="text-dark">Tracking number: <? echo $tracking ?></h7>
                <h7 class="text-dark">Registrado el: <? echo $fecha_creacion ?></h7>
                <h7 class="text-dark">Escaneado por: <? echo $user_fullname ?> (<? echo $username ?>)</h7>
                <!-- <a href="edit.php?tracking=<? echo $tracking ?>" class="fs-6 fw-semibold link-primary">
                    Editar
                </a> -->
            </div>
            <!--end::Content-->
            <!--begin::Separator-->
            <!--end::Separator-->

            <div class="separator separator-dashed mb-9"></div>
            <form method="post">
                <div class="row g-12">
                    <!--begin::Col-->
                    <div class="row mw-500px mb-5" data-kt-buttons="true" data-kt-buttons-target=".form-check-image, .form-check-input">
                        <!--begin::Col-->
                        <div class="col-8">
                            <video id="webcam" autoplay playsinline width="400" height="480"></video>
                        </div>
                    </div>
                    <div class="row mw-500px mb-5" data-kt-buttons="true" data-kt-buttons-target=".form-check-image, .form-check-input">
                        <!--begin::Col-->
                        <div class="col-10">
                            <img id="photoPreview" style="display: none; border: 1px solid #000; margin-top:90px; max-width:400px;">
                        </div>
                        <div class="col-8">
                            <button class="btn btn-primary hover-elevate-up" type="button" id="capture">Tomar foto</button>
                            <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
                    </div>
                    </div>
                    <?php
                    foreach ($images as $key => $image) {
                        $timestamp = time(); ?>
                        <div class="row mw-500px mb-5" data-kt-buttons="true" data-kt-buttons-target=".form-check-image, .form-check-input">
                            <!--begin::Col-->
                            <div class="col-10">
                                <label class="form-check-image active">
                                    <div class="form-check-wrapper">
                                        <?
                                        if (isset($data[$key])) {
                                            echo "<img src='{$image}?v={$timestamp}' alt='Imagen de {$key}' width='900'><br>"; // Note el ?v={$timestamp} 
                                        } else {
                                            echo "No hay imagen para {$key}. Puedes tomar una nueva foto.<br>";
                                        } ?>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <? echo "<input type='radio' class='form-check-input h-30px w-30px' name='image_to_replace' value='{$key}'>"; ?>
                                        <div class="form-check-label">
                                           <?php if($key=='parts'){
                                            echo 'Small Parts';
                                           }else{
                                            echo 'Empaque';
                                           } ?> 
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="image">
                            <input class="btn btn-success hover-elevate-up" type="submit" value="Reemplazar Imagen" id="submit" disabled>
                </div>
            </form>
            <!--end::Row-->
        </div>
    </div>
</div>
<script>
    const video = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const captureButton = document.getElementById('capture');
    const preview = document.getElementById('photoPreview'); // Nuestro nuevo elemento para la vista previa
    const submitButton = document.getElementById('submit');
    const imageInput = document.querySelector('input[name="image"]');
    const radioInputs = document.querySelectorAll('input[type="radio"]');
    // Configuración de la webcam
    function checkReadyState() {
        if (imageInput.value && [...radioInputs].some(radio => radio.checked)) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }
    navigator.mediaDevices.getUserMedia({
            video: true
        })
        .then(stream => {
            video.srcObject = stream;
            return video.play();
        })
        .catch(err => {
            console.error("Error accessing the camera.", err);
        });

    // Evento para el botón "Tomar foto"
    captureButton.addEventListener('click', function() {
        // Dibuja la imagen actual de la webcam en el canvas
        context.drawImage(video, 0, 0, 640, 480);

        // Obtiene la imagen del canvas en formato Data URL
        const imageData = canvas.toDataURL('image/png');

        // Establece la imagen capturada como el contenido de nuestro elemento de vista previa
        preview.src = imageData;
        preview.style.display = 'block'; // Hace visible la vista previa

        // Guarda la imagen en el input hidden para enviarla al servidor
        document.querySelector('input[name="image"]').value = imageData;
    });
    radioInputs.forEach(radio => {
        radio.addEventListener('change', checkReadyState);
    });
</script>
<?php require('class/footer.php'); ?>