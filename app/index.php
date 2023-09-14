<?php require('class/header.php'); ?>
<?php require('class/user_data.php'); ?>
<div class="app-container  container-xxl ">

	<div class="app-container  container-xxl ">
		<!--begin::Main-->
		<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
			<!--begin::Content wrapper-->
			<div class="d-flex flex-column flex-column-fluid">
				<!--begin::Content-->
				<div id="kt_app_content" class="app-content ">

					<!--begin::Navbar-->
					<div class="card mb-5 mb-xl-10">
						<div class="card-body pt-10 pb-0">
							<!--begin::Details-->
							<div class="d-flex flex-wrap flex-sm-nowrap">
								<!--begin: Pic-->
								<div class="me-7 mb-4">
									<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
										<img src="assets/media/avatars/cow.png" alt="image">
										<div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
									</div>
								</div>
								<!--end::Pic-->

								<!--begin::Info-->
								<div class="flex-grow-1">
									<!--begin::Title-->
									<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
										<!--begin::User-->
										<div class="d-flex flex-column">
											<!--begin::Name-->
											<div class="d-flex align-items-center mb-2">
												<a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><? echo $fullname ?></a>
												<a href="#"><i class="ki-outline ki-verify fs-1 text-primary"></i></a>
											</div>
											<!--end::Name-->

											<!--begin::Info-->
											<div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-1">
												<a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
													<i class="ki-outline ki-profile-circle fs-4 me-1"></i> <? echo $descripcion; ?>
												</a>
												<a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
													<i class="ki-outline ki-geolocation fs-4 me-1"></i> Tijuana, BC
												</a>
												<a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
													<i class="ki-outline ki-sms fs-4"></i> <? echo $email; ?>
												</a>
												<a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
												<i class="ki-outline ki-time fs-4 me-1"></i><span id="hora-actual"></span>
													
												</a>
											</div>
											<!--end::Info-->
										</div>
										<!--end::User-->
									</div>
									<!--end::Title-->

									<!--begin::Stats-->
									<div class="d-flex flex-wrap flex-stack">
										<!--begin::Wrapper-->
										<div class="d-flex flex-column flex-grow-1 pe-8">
											<!--begin::Stats-->
											<div class="d-flex flex-wrap">
												<!--begin::Stat-->
												<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
													<!--begin::Number-->
													<div class="d-flex align-items-center">
														<i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
														<div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="4500" data-kt-initialized="1"><?php echo $total_user ?></div>
													</div>
													<!--end::Number-->

													<!--begin::Label-->
													<div class="fw-semibold fs-6 text-gray-400">Carros Registrados</div>
													<!--end::Label-->
												</div>
												<!--end::Stat-->

												<!--begin::Stat-->
												<!-- <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
													<div class="d-flex align-items-center">
														<i class="ki-outline ki-arrow-down fs-3 text-danger me-2"></i>
														<div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="80" data-kt-initialized="1">80</div>
													</div>
													<div class="fw-semibold fs-6 text-gray-400">Projects</div>
												</div> -->
												<!--end::Stat-->
											</div>
											<!--end::Stats-->
										</div>
										<!--end::Wrapper-->

										<!--begin::Progress-->
										<div class="d-flex align-items-center w-200px w-sm-200px flex-column mt-1">
											<div class="d-flex justify-content-between w-180 mt-auto mb-9">
												<a href="search.php" class="btn btn-xl btn-success align-self-center">Buscar Empque</a>
												<img class="mw-130 mh-90px" alt="" src="assets/media/illustrations/sigma-1/5.png">
											</div>
										</div>
										<!--end::Progress-->
									</div>
									<!--end::Stats-->
								</div>
								<!--end::Info-->
							</div>
							<!--end::Details-->
						</div>
					</div>
					<!--end::Navbar-->
					<!--begin::details View-->
					<div class="card">
						<!--begin::Card body-->
						<div class="card-body p-0">
							<!--begin::Wrapper-->
							<div class="card-px text-center py-2 my-1">
								<!--begin::Title-->
								<h2 class="fs-2x fw-bolder mb-10">Te damos la bienvenida!</h2>
								<!--end::Title-->
								<!--begin::Description-->
								<p class="text-gray-400 fs-4 fw-bold mb-10">
									Uriel <br> Asegurate de Escanear el Tracking Number y Tomar Las Fotos del Empaque y de Small Parts </p>
								<!--end::Description-->
								<!--begin::Action-->
								<a href="photo.php" class="btn btn-primary">Agregar Evidencia</a>
								<!--end::Action-->
							</div>
							<!--end::Wrapper-->

							<!--begin::Illustration-->
							<div class="text-center px-4">

								<img class="mw-100 mh-300px" alt="" src="assets/media/illustrations/sigma-1/2.png">
							</div>
							<!--end::Illustration-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::details View-->
				</div>
				<!--end::Content-->

			</div>
			<!--end::Content wrapper-->
		</div>
		<!--end:::Main-->
	</div>



	<?php require('class/footer.php'); ?>