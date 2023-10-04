<?php
$lista = 1;
include 'class/header.php';
?>
<div class="app-container container-xxl">
    <!-- ... Tu código HTML existente ... -->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content">
                <div class="card">
                    <!-- Inicio de la sección de la tabla -->
                    <div class="card-body py-4">
                        <!-- Tabla -->
                        <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_table_users">
                                    <?php
                                    // Conexión a la base de datos (reemplaza con tus datos de conexión)
                                    include('class/data.php');
                                    // Verificar la conexión
                                    if ($conexion->connect_error) {
                                        die("Error de conexión: " . $conexion->connect_error);
                                    }
                                    // Paginación
                                    $items_por_pagina = 100;
                                    $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                                    $offset = ($pagina_actual - 1) * $items_por_pagina;
                                    // Consulta SQL para obtener los datos de la tabla "carros"
                                    $editado = isset($_GET['edit']) ? $_GET['edit'] : 0;
                                    $scan = isset($_GET['scan']) ? $_GET['scan'] : 0;
                                    if ($editado == 1) {
                                        $sql = "SELECT carros.*, users.nombre, users.apellidos, users.username 
                                                    FROM carros 
                                                    LEFT JOIN users ON carros.fk_user = users.id_user 
                                                    WHERE carros.editado = TRUE
                                                    LIMIT $items_por_pagina OFFSET $offset";
                                    } else {
                                        if ($scan == 0) {
                                            // Consulta para mostrar todos los registros
                                            $sql = "SELECT carros.*, users.nombre, users.apellidos, users.username 
                                                        FROM carros 
                                                        LEFT JOIN users ON carros.fk_user = users.id_user 
                                                        LIMIT $items_por_pagina OFFSET $offset";
                                        } elseif ($scan == 1) {
                                            // Consulta para mostrar registros con empaque o parts NULL o en blanco
                                            $sql = "SELECT carros.*, users.nombre, users.apellidos, users.username 
                                                        FROM carros 
                                                        LEFT JOIN users ON carros.fk_user = users.id_user 
                                                        WHERE (carros.empaque IS NULL OR carros.empaque = '') 
                                                        OR (carros.parts IS NULL OR carros.parts = '')
                                                        LIMIT $items_por_pagina OFFSET $offset";
                                        } else {
                                            $sql = "SELECT carros.*, users.nombre, users.apellidos, users.username 
                                                FROM carros 
                                                LEFT JOIN users ON carros.fk_user = users.id_user 
                                                LIMIT $items_por_pagina OFFSET $offset";
                                        }
                                    }
                                    $result = $conexion->query($sql); ?>
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-10px pe-2 sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 29.8828px;">
                                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1">
                                                </div>
                                            </th>
                                            <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="User: activate to sort column ascending" style="width: 261.367px;">Tracking Number</th>
                                            <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending" style="width: 152.734px;">Registrado por</th>
                                            <!-- <?php
                                                    if ($editado == 1) {
                                                        echo "<th class='min-w-125px sorting' tabindex='0' aria-controls='kt_table_users' rowspan='1' colspan='1' aria-label='Last login: activate to sort column ascending' style='width: 152.734px;'>Editado</th>";
                                                    }
                                                    ?> -->
                                            <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="Last login: activate to sort column ascending" style="width: 152.734px;">Small Parts</th>
                                            <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="Two-step : activate to sort column ascending" style="width: 152.734px;">Empaque</th>
                                            <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" aria-label="Joined Date: activate to sort column ascending" style="width: 203.418px;">Fecha creaciòn</th>
                                            <th class="text-end min-w-100px sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 124.941px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                // Mostrar cada fila de la tabla
                                                echo "<tr>";
                                                echo "<td><div class='form-check form-check-sm form-check-custom form-check-solid'><input class='form-check-input' type='checkbox' value='1'></div></td>";
                                                echo "<td class='d-flex align-items-center'>";
                                                echo "<div class='symbol symbol-circle symbol-50px overflow-hidden me-3'><a href='#'><div class='symbol-label'><img src='assets/media/avatars/cow.png' alt='user' class='w-50'></div></a></div>";
                                                echo "<div class='d-flex flex-column'><a href='search.php?trackingNumber=" . $row['tracking'] . "' class='text-gray-800 text-hover-primary mb-1'>" . $row['tracking'] . "</a></div>";

                                                echo "</td>";
                                                echo "<td>" . $row['nombre'] .  ' ' . $row['apellidos'] . ' (' . $row['username'] . ')' . "</td>";

                                                // Mostrar el campo "Small Parts" como una etiqueta si existe
                                                echo "<td data-order='" . $row['creacion'] . "'>";
                                                if (!empty($row['parts'])) {
                                                    echo "<div class='badge badge-light-success fw-bold'>Small Parts</div>";
                                                }
                                                echo "</td>";

                                                // Mostrar el campo "Empaque" como una etiqueta si existe
                                                echo "<td>";
                                                if (!empty($row['empaque'])) {
                                                    echo "<div class='badge badge-light-success fw-bold'>Empaque</div>";
                                                }
                                                echo "</td>";

                                                // Mostrar la columna "creacion"
                                                echo "<td data-order='" . $row['creacion'] . "'>" . $row['creacion'] . "</td>";

                                                // Acciones
                                                echo "<td class='text-end'>";
                                                echo "<a href='#' class='btn btn-light btn-active-light-primary btn-flex btn-center btn-sm' data-kt-menu-trigger='click' data-kt-menu-placement='bottom-end'>Actions<i class='ki-outline ki-down fs-5 ms-1'></i></a>";
                                                echo "<div class='menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4' data-kt-menu='true'>";
                                                echo "<div class='menu-item px-3'><a href='search.php?trackingNumber=" . $row['tracking'] . "' class='menu-link px-3'>Revisar</a></div>";
                                                echo "<div class='menu-item px-3'><a href='edit.php?tracking=" . $row['tracking'] . "' class='menu-link px-3' data-kt-users-table-filter='delete_row'>Editar</a></div>";
                                                echo "</div>";
                                                echo "</td>";

                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No se encontraron registros.</td></tr>";
                                        }

                                        // Cerrar la conexión
                                        $conexion->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Paginador -->
                            <div class="row">
                                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div>
                                <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                    <div class="dataTables_paginate paging_simple_numbers" id="kt_table_users_paginate">
                                        <ul class="pagination">
                                            <?php
                                            // Calcular el número total de páginas
                                            include('class/data.php');

                                            if ($editado == 1) {
                                                $sql = "SELECT COUNT(*) AS total FROM carros WHERE carros.editado = TRUE";
                                            } else {
                                                if ($scan == 0) {
                                                    $sql = "SELECT COUNT(*) AS total FROM carros";
                                                } elseif ($scan == 1) {
                                                    $sql = "SELECT COUNT(*) AS total FROM carros WHERE (carros.empaque IS NULL OR carros.empaque = '') OR (carros.parts IS NULL OR carros.parts = '')";
                                                } else {
                                                    $sql = "SELECT COUNT(*) AS total FROM carros";
                                                }
                                            }

                                            $result = $conexion->query($sql);
                                            $row = $result->fetch_assoc();
                                            $total_items = $row['total'];
                                            $total_paginas = ceil($total_items / $items_por_pagina);

                                            // Calcular los números de página que se mostrarán
                                            $numero_paginas_a_mostrar = 8; // Cambia esto para mostrar más o menos números de página
                                            $mitad = floor($numero_paginas_a_mostrar / 2);
                                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                                            $pagina_inicial = max(1, $pagina_actual - $mitad);
                                            $pagina_final = min($total_paginas, $pagina_inicial + $numero_paginas_a_mostrar - 1);

                                            // Mostrar botón para la primera página
                                            echo "<li class='paginate_button page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "'>";
                                            if ($editado == 1) {
                                                echo "<a href='lista.php?edit=1&pagina=1' aria-controls='kt_table_users' tabindex='0' class='page-link'><<</a>";
                                            } else {
                                                if ($scan == 0) {
                                                    echo "<a href='lista.php?scan=0&pagina=1' aria-controls='kt_table_users' tabindex='0' class='page-link'><<</a>";
                                                } elseif ($scan == 1) {
                                                    echo "<a href='lista.php?scan=1&pagina=1' aria-controls='kt_table_users' tabindex='0' class='page-link'><<</a>";
                                                } else {
                                                    echo "<a href='lista.php?pagina=1' aria-controls='kt_table_users' tabindex='0' class='page-link'><<</a>";
                                                }
                                            }
                                            echo "</li>";

                                            // Mostrar números de página
                                            for ($i = $pagina_inicial; $i <= $pagina_final; $i++) {
                                                echo "<li class='paginate_button page-item " . ($i == $pagina_actual ? 'active' : '') . "'>";
                                                if ($editado == 1) {
                                                    echo "<a href='lista.php?edit=1&pagina=$i' aria-controls='kt_table_users' data-dt-idx='$i' tabindex='0' class='page-link'>$i</a>";
                                                } else {
                                                    if ($scan == 0) {
                                                        echo "<a href='lista.php?scan=0&pagina=$i' aria-controls='kt_table_users' data-dt-idx='$i' tabindex='0' class='page-link'>$i</a>";
                                                    } elseif ($scan == 1) {
                                                        echo "<a href='lista.php?scan=1&pagina=$i' aria-controls='kt_table_users' data-dt-idx='$i' tabindex='0' class='page-link'>$i</a>";
                                                    } else {
                                                        echo "<a href='lista.php?pagina=$i' aria-controls='kt_table_users' data-dt-idx='$i' tabindex='0' class='page-link'>$i</a>";
                                                    }
                                                }
                                                echo "</li>";
                                            }

                                            // Mostrar botón para la última página
                                            echo "<li class='paginate_button page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "'>";
                                            if ($editado == 1) {
                                                echo "<a href='lista.php?edit=1&pagina=$total_paginas' aria-controls='kt_table_users' tabindex='0' class='page-link'>>></a>";
                                            } else {
                                                if ($scan == 0) {
                                                    echo "<a href='lista.php?scan=0&pagina=$total_paginas' aria-controls='kt_table_users' tabindex='0' class='page-link'>>></a>";
                                                } elseif ($scan == 1) {
                                                    echo "<a href='lista.php?scan=1&pagina=$total_paginas' aria-controls='kt_table_users' tabindex='0' class='page-link'>>></a>";
                                                } else {
                                                    echo "<a href='lista.php?pagina=$total_paginas' aria-controls='kt_table_users' tabindex='0' class='page-link'>>></a>";
                                                }
                                            }
                                            echo "</li>";

                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin de la tabla -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ... Tu código HTML existente ... -->

    <?php
    include 'class/footer.php';
    ?>