<?php
require('class/header.php');

$trackingInfo = null;

if (isset($_GET['trackingNumber'])) {
    $tracking = $_GET['trackingNumber'];

    // Prepared statement to prevent SQL Injection
    $stmt = $conexion->prepare("
        SELECT carros.*, users.nombre, users.apellidos, users.username 
        FROM carros 
        JOIN users ON carros.fk_user = users.id_user 
        WHERE carros.tracking = ?
    ");

    $stmt->bind_param("s", $tracking);  // "s" means we're binding a string parameter

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $trackingInfo = $result->fetch_assoc();  // fetch the first row
        $user_fullname = $trackingInfo['nombre'] . " " . $trackingInfo['apellidos'];
        $username = $trackingInfo['username'];
        $tracking = $trackingInfo['tracking'];
        $small_parts = $trackingInfo['parts'];
        $empaque = $trackingInfo['empaque'];
        $fecha_creacion = $trackingInfo['creacion'];
    }

    $stmt->close();
}

require('class/user_data.php');
?>

<div class="app-container container-xxl ">
    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content ">

                <div class="card ">
                    <div class="rounded border p-5">
                        <h2 class="fs-2x fw-bold mb-10">Buscar Tracking Number</h2>
                        <!--begin::Input group-->
                        <form action="" method="get">
                            <input type="text" class="form-control " aria-label="Username" aria-describedby="basic-addon1" id="trackingInput" name="trackingNumber" placeholder="Ingresa el Tracking Numer..." maxlength="7">
                            <center>
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </center>
                        </form>
                        <!--end::Input group-->
                    </div>
                    <!-- [remaining content...] -->
                </div>

                <div class="card-body p-lg-5 pb-lg-0">
                    <!--begin::Card body-->

                    <div class="separator separator-dashed mb-5"></div>
                    <?php
                    if ($trackingInfo) {
                    ?>
                        <div class="mb-17">
                            <!--begin::Content-->
                            <div class="d-flex flex-stack mb-5">
                                <!--begin::Title-->
                                <h7 class="text-dark">Tracking number: <? echo $tracking ?></h7>
                                <h7 class="text-dark">Registrado el: <? echo $fecha_creacion ?></h7>
                                <h7 class="text-dark">Escaneado por: <? echo $user_fullname ?> (<? echo $username ?>)</h7>
                                <a href="edit.php?tracking=<?echo $tracking ?>" class="fs-6 fw-semibold link-primary">
                                    Editar
                                </a>
                            </div>
                            <!--end::Content-->
                            <!--begin::Separator-->
                            <!--end::Separator-->
                            <div class="separator separator-dashed mb-9"></div>

                            <div class="row g-12">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Hot sales post-->
                                    <div class="card-xl-stretch me-md-6">
                                        <h2 class="fs-1x mb-1">Small Parts</h2>
                                        <!--begin::Overlay-->
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales" href="<? echo $trackingInfo['parts'] ?>">
                                            <!--begin::Image-->
                                            <div id="empaque" class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-325px" style="background-image:url('<?php echo $trackingInfo['parts'] ?>')">
                                            </div>
                                            <!--end::Image-->

                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-outline ki-eye fs-2x text-white"></i>
                                            </div>
                                            <!--end::Action-->
                                        </a>
                                        <!--end::Overlay-->
                                    </div>
                                    <!--end::Hot sales post-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Hot sales post-->
                                    <div class="card-xl-stretch mx-md-3">
                                        <h2 class="fs-1x mb-1">Empaque</h2>
                                        <!--begin::Overlay-->
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales" href="<? echo $trackingInfo['empaque'] ?>">
                                            <!--begin::Image-->
                                            <div id="parts" class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-325px" style="background-image:url('<?php echo $trackingInfo['empaque'] ?>')">
                                            </div>
                                            <!--end::Image-->

                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-outline ki-eye fs-2x text-white"></i>
                                            </div>
                                            <!--end::Action-->
                                        </a>
                                        <!--end::Overlay-->
                                    </div>
                                    <!--end::Hot sales post-->
                                </div>
                                <!--end::Col-->
                            </div>
                        <?  } elseif (isset($_GET['trackingNumber'])) {
                        echo "<p>No results found for " . $_GET['trackingNumber'] . "</p>";
                    } ?>
                        <!--end::Row-->
                        </div>
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
</div>
</div>
<script src="assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
<?php require('class/footer.php'); ?>