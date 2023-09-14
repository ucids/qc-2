<?php
session_start();
require 'class/data.php';
if (isset($_SESSION['user_id'])) {
	$records = $conn->prepare('SELECT users.*, roles.* FROM users INNER JOIN roles ON users.fk_rol = roles.id_rol WHERE users.id_user = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	$user = null;
	require 'class/session.php';
	if (count($results) > 0) {
		$user = $results;
	}
} else {
	header("Location: session/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<base href="index.php" />
	<title>Katzkin | QC</title>
	<meta charset="utf-8" />
	<meta name="description" content="Sistema de recolecion de evidencia para el departamento de Calidad" />
	<meta name="keywords" content="katzkin, qc, tj" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="https://cloudhunter.solutions" />
	<meta property="og:site_name" content="cloudhunter.solutions" />
	<link rel="canonical" href="https://preview.cloudhunter.solutions" />
	<link rel="shortcut icon" href="assets/media/logos/katzkin.png" />
	<!--begin::Fonts(mandatory for all pages)-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Vendor Stylesheets(used for this page only)-->
	<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Vendor Stylesheets-->
	<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		// Función para actualizar la hora cada segundo
		function actualizarHora() {
			// Obtener la fecha y hora actual en JavaScript
			var fechaHora = new Date();

			// Formatear la fecha y hora como desees
			var horaActual = fechaHora.toLocaleTimeString(); // Formato: Hora:Minuto:Segundo

			// Actualizar el elemento HTML con la nueva hora
			$("#hora-actual").text(horaActual);
		}

		// Actualizar la hora cada segundo (1000 milisegundos)
		setInterval(actualizarHora, 1000);
	</script>
	<!--end::Global Stylesheets Bundle-->
	<script>
		// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
	</script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-toolbar-enabled="true" class="app-default">
	<!--begin::Theme mode setup on page load-->
	<!--end::Theme mode setup on page load-->
	<!--begin::App-->
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<!--begin::Page-->
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<!--begin::Header-->
			<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">
				<!--begin::Header container-->
				<div class="app-container container-xxl d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
					<!--begin::Header mobile toggle-->
					<div class="d-flex align-items-center d-lg-none ms-n3 me-2" title="Show sidebar menu">
						<div class="btn btn-icon btn-color-gray-600 btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
							<i class="ki-outline ki-abstract-14 fs-2"></i>
						</div>
					</div>
					<!--end::Header mobile toggle-->
					<!--begin::Logo-->
					<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
						<a href="index.php">
							<img alt="Logo" src="assets/media/logos/ktzb.png" class="h-55px d-none d-lg-inline app-sidebar-logo-default theme-light-show" />
						</a>
					</div>
					<!--end::Logo-->
					<!--begin::Header wrapper-->
					<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
						<!--begin::Menu wrapper-->
						<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
							<!--begin::Menu-->
							<div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
									<!--begin:Menu link-->
									<span class="menu-link">
										<a href="index.php">
											<span class="menu-title">Inicio</span>
										</a>
									</span>

									<!--end:Menu link-->
								</div>
								<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-title">Sesión</span>
										<span class="menu-arrow d-lg-none"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="lista.php" title="Termina la sesion actual" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
												<span class="menu-icon">
													<i class="ki-outline ki-rocket fs-2"></i>
												</span>
												<span class="menu-title">Registros</span>
											</a>
											<a class="menu-link" href="session/logout.php" title="Termina la sesion actual" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
												<span class="menu-icon">
													<i class="ki-outline ki-rocket fs-2"></i>
												</span>
												<span class="menu-title">Cerrar Sesión</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
							</div>
							<!--end::Menu-->
						</div>
						<!--end::Menu wrapper-->
						<!--begin::Navbar-->
						<div class="app-navbar flex-shrink-0">
							<!--begin::Search-->
							<div class="d-flex align-items-center align-items-stretch mx-4">
								<!--begin::Search-->
								<div id="kt_header_search" class="header-search d-flex align-items-center w-lg-200px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start">
									<!--begin::Tablet and mobile search toggle-->
									<div data-kt-search-element="toggle" class="search-toggle-mobile d-flex d-lg-none align-items-center">
										<div class="d-flex">
											<button type="submit" class="btn btn-primary">
												<i class="ki-outline ki-magnifier fs-1"></i>
											</button>
										</div>
									</div>
									<!--end::Tablet and mobile search toggle-->
									<!--begin::Form(use d-none d-lg-block classes for responsive search)-->
									<form action="search.php" method="get" class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">
										<!--begin::Hidden input(Added to disable form autocomplete)-->
										<input type="hidden" />
										<!--end::Hidden input-->
										<!--begin::Icon-->
										<i class="ki-outline ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5"></i>
										<!--end::Icon-->
										<!--begin::Input-->
										<input type="text" class="search-input form-control form-control ps-13" name="trackingNumber" value="" placeholder="Search..." data-kt-search-element="input" maxlength="7" />
										<!--end::Input-->
										<!--begin::Spinner-->
										<span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
											<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
										</span>
										<!--end::Spinner-->
										<!--begin::Reset-->
										<span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4" data-kt-search-element="clear">
											<i class="ki-outline ki-cross fs-2 fs-lg-1 me-0"></i>
										</span>
										<!--end::Reset-->
									</form>
									<!--end::Form-->
								</div>
								<!--end::Search-->
							</div>
							<!--end::Search-->
							<!--begin::User menu-->
							<div class="app-navbar-item ms-3 ms-lg-5" id="kt_header_user_menu_toggle">
								<!--begin::Menu wrapper-->
								<div class="cursor-pointer symbol symbol-35px symbol-md-45px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<img class="symbol symbol-circle symbol-35px symbol-md-45px" src="assets/media/avatars/cow.png" alt="user" />
								</div>
								<!--begin::User account menu-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<div class="menu-content d-flex align-items-center px-3">
											<!--begin::Avatar-->
											<div class="symbol symbol-50px me-5">
												<img alt="Logo" src="assets/media/avatars/cow.png" />
											</div>
											<!--end::Avatar-->
											<!--begin::Username-->
											<div class="d-flex flex-column">
												<div class="fw-bold d-flex align-items-center fs-5"><? echo $fullname; ?>
													<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">QC</span>
												</div>
												<a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><? echo $email; ?></a>
											</div>
											<!--end::Username-->
										</div>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu separator-->
									<div class="separator my-2"></div>
									<!--end::Menu separator-->
									<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="index.php" class="menu-link px-5">My Profile</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu separator-->
									<div class="separator my-2"></div>
									<!--end::Menu separator-->
									<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="session/logout.php" class="menu-link px-5">Salir</a>
									</div>
									<!--end::Menu item-->
								</div>
								<!--end::User account menu-->
								<!--end::Menu wrapper-->
							</div>
							<!--end::User menu-->
							<!--begin::Header menu toggle-->
							<!--end::Header menu toggle-->
						</div>
						<!--end::Navbar-->
					</div>
					<!--end::Header wrapper-->
				</div>
				<!--end::Header container-->
			</div>
			<!--end::Header-->
			<!--begin::Wrapper-->
			<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
				<!--begin::Toolbar-->
				<div id="kt_app_toolbar" class="app-toolbar py-6">
					<!--begin::Toolbar container-->
					<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
						<!--begin::Toolbar container-->
						<div class="d-flex flex-column flex-row-fluid">
							<!--begin::Toolbar wrapper-->
							<!--end::Toolbar wrapper=-->
							<!--begin::Toolbar wrapper=-->
							<div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-6 pb-18 py-lg-3">
								<!--begin::Page title-->
								<div class="page-title d-flex align-items-center me-3">
									<img alt="Logo" src="assets/media/logos/katzkin.png" class="h-60px me-5" />
									<!--begin::Title-->
									<h1 class="page-heading d-flex text-white fw-bolder fs-2 flex-column justify-content-center my-0">QC Dashboard
										<!--begin::Description-->
										<span class="page-desc text-white opacity-50 fs-6 fw-bold pt-4">Control de Calidad</span>
										<!--end::Description-->
									</h1>
									<!--end::Title-->
								</div>
								<?php
								if (isset($lista)) {
									require('class/data.php');
									$sql_total = "SELECT COUNT(*) AS total_elementos FROM carros";
									$result_total = $conexion->query($sql_total);
									$row_total = $result_total->fetch_assoc();
									$total_elementos = $row_total['total_elementos'];

									// Consulta para contar elementos completos
									$sql_completos = "SELECT COUNT(*) AS total_completos FROM carros WHERE (empaque IS NOT NULL AND empaque != '') AND (parts IS NOT NULL AND parts != '')";
									$result_completos = $conexion->query($sql_completos);
									$row_completos = $result_completos->fetch_assoc();
									$total_completos = $row_completos['total_completos'];

									// Consulta para contar elementos editados
									$sql_editados = "SELECT COUNT(*) AS total_editados FROM carros WHERE editado = 1";
									$result_editados = $conexion->query($sql_editados);
									$row_editados = $result_editados->fetch_assoc();
									$total_editados = $row_editados['total_editados'];

									// Calcular elementos no completos restando elementos completos de elementos totales
									$total_no_completos = $total_elementos - $total_completos;

									// Cerrar la conexión
									$conexion->close();

								?>
									<div class="d-flex gap-4 gap-lg-13">
										<!--begin::Item-->
										<a href="lista.php">
											<div class="d-flex flex-column">
												<!--begin::Number-->
												<span class="text-white fw-bold fs-3 mb-1"><? echo $total_elementos; ?></span>
												<!--end::Number-->
												<!--begin::Section-->
												<div class="text-white opacity-50 fw-bold">Carros Escaneados</div>
												<!--end::Section-->
											</div>
										</a>
										<!--end::Item-->
										<!--begin::Item-->
										<a href="lista.php?scan=0">
											<div class="d-flex flex-column">
												<!--begin::Number-->
												<span class="text-white fw-bold fs-3 mb-1"><? echo $total_completos; ?></span>
												<!--end::Number-->
												<!--begin::Section-->
												<div class="text-white opacity-50 fw-bold">Escaneos Completos</div>
												<!--end::Section-->
											</div>
										</a>
										<!--end::Item-->
										<!--begin::Item-->
										<a href="lista.php?scan=1">
											<div class="d-flex flex-column">
												<!--begin::Number-->
												<span class="text-white fw-bold fs-3 mb-1"><? echo $total_no_completos ?></span>
												<!--end::Number-->

												<!--begin::Section-->
												<div class="text-white opacity-50 fw-bold">Escaneos Incompletos</div>
												<!--end::Section-->
											</div>
										</a>
										<!--end::Item-->
										<!--begin::Item-->
										<a href="lista.php?edit=1">
											<div class="d-flex flex-column">
												<!--begin::Number-->
												<span class="text-white fw-bold fs-3 mb-1"><? echo $total_editados ?></span>
												<!--end::Number-->

												<!--begin::Section-->
												<div class="text-white opacity-50 fw-bold">Escaneos Editados</div>
												<!--end::Section-->
											</div>
										</a>
										<!--end::Item-->

									</div>
								<?php } ?>
								<!--end::Page title-->
								<div class="d-flex gap-2 gap-lg-3">
									<a href="#" class="btn btn-success"><i class="fas fa-home fs-4 me-2"></i> Inicio</a>
									<a href="photo.php" class="btn btn-danger"><i class="fas fa-camera fs-4 me-2"></i> Nuevo Registro</a>

								</div>
							</div>
							<!--end::Toolbar wrapper=-->
						</div>
						<!--end::Toolbar container=-->
					</div>
					<!--end::Toolbar container-->
				</div>
				<!--end::Toolbar-->