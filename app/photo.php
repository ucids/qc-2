<?php require('class/header.php'); ?>
<!--begin::Wrapper container-->
<div class="app-container container-xxl">
	<!--begin::Main-->
	<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
		<!--begin::Content wrapper-->
		<div class="d-flex flex-column flex-column-fluid">
			<!--begin::Content-->
			<div id="kt_app_content" class="app-content">
				<!--begin::Layout-->
				<div class="d-flex flex-column flex-lg-row">
					<!--begin::Content-->
					<div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
						<!--begin::Form-->
						<form class="form" action="#" id="kt_subscriptions_create_new">
							<!--begin::Customer-->
							<div class="card card-flush pt-3 mb-5 mb-lg-10">
								<!--begin::Card header-->
								<div class="card-header">
									<!--begin::Card title-->
									<div class="card-title">
										<h2 class="fw-bold">Camara</h2>
									</div>
									<div id="message-container">
										<div id="success-message" style="display: none;"></div>
										<div id="error-message" style="color: red;"></div> <!-- Error message element -->
									</div>
									<!--begin::Card title-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<video id="camera-feed" autoplay></video>
								<div class="card-body pt-0">
									<!--begin::Description-->
									<div class="text-gray-500 fw-semibold fs-5 mb-5">Revisa la camara antes de tomar la Foto:</div>
									<!--end::Description-->
								</div>
								<!--end::Card body-->
							</div>
							<!--end::Customer-->
							<!--begin::Pricing-->
							<div class="card card-flush pt-3 mb-5 mb-lg-10">
								<!--begin::Card header-->
								<div class="card-header">
									<!--begin::Card title-->
									<div class="card-title">
										<h2 class="fw-bold">Small Parts</h2>
									</div>
									<!--begin::Card title-->
									<!--begin::Card toolbar-->
									<div class="card-toolbar">
										<!-- <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_product">Add Product</button> -->

									</div>
									<!--end::Card toolbar-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<canvas id="small-parts-canvas" style="display: none;"></canvas>
								<img id="captured-small-parts-photo" src="" alt="Captured Small Parts Photo">
								<div class="card-body pt-0">
								</div>
								<!--end::Card body-->
							</div>
							<!--end::Pricing-->
							<!--begin::Payment method-->
							<div class="card card-flush pt-3 mb-5 mb-lg-10" data-kt-subscriptions-form="pricing">
								<!--begin::Card header-->
								<div class="card-header">
									<!--begin::Card title-->
									<div class="card-title">
										<h2 class="fw-bold">Empaque</h2>
									</div>
									<!--begin::Card title-->
									<!--begin::Card toolbar-->
									<div class="card-toolbar">

									</div>
									<!--end::Card toolbar-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<canvas id="empaque-canvas" style="display: none;"></canvas>
								<img id="captured-empaque-photo" src="" alt="Captured Empaque Photo">
								<div class="card-body pt-0">

								</div>
								<!--end::Card body-->
							</div>
							<!--end::Payment method-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Content-->
					<!--begin::Sidebar-->
					<div class="flex-column flex-lg-row-auto w-100 w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
						<!--begin::Card-->
						<div class="card card-flush pt-3 mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary" data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
							<!--begin::Card header-->
							<div class="card-header">
								<!--begin::Card title-->
								<div class="card-title">
									<h2>Tracking Number</h2>
								</div>
								<!--end::Card title-->
							</div>
							<!--end::Card header-->
							<!--begin::Card body-->
							<div class="card-body pt-0 fs-6">
								<!--begin::Section-->
								<div class="mb-7">
									<!--begin::Title-->
									<!--end::Title-->
									<!--begin::Details-->
									<div class="d-flex align-items-center mb-9">
										<input type="text" class="form-control" maxlength="7" id="tracking-number" placeholder="Enter Tracking Number">
									</div>
									<div class="d-flex align-items-center mb-1">
										<!--begin::Name-->
										<a href="#" class="fw-bold text-gray-800 text-hover-primary me-2"><? echo $fullname; ?></a>
										<!--end::Name-->
										<!--begin::Status-->
										<span class="badge badge-light-success">QC</span>
										<!--end::Status-->
									</div>
									<!--end::Details-->
									<!--begin::Email-->
									<a href="#" class="fw-semibold text-gray-600 text-hover-primary"><? echo $email; ?></a>
									<!--end::Email-->
								</div>
								<!--end::Section-->
								<!--begin::Seperator-->
								<div class="separator separator-dashed mb-7"></div>
								<!--end::Seperator-->
								<!--begin::Section-->
								<div class="mb-7">
									<!--begin::Title-->
									<h5 class="mb-3">Capturar: Small Parts</h5>
									<!--end::Title-->
									<!--begin::Details-->
									<div class="mb-0">
										<!--begin::Plan-->
										<button class="btn btn-light-primary" id="capture-small-parts-btn">Capturar Small Parts</button>

										<!--end::Price-->
									</div>
									<!--end::Details-->
								</div>
								<!--end::Section-->
								<!--begin::Seperator-->
								<div class="separator separator-dashed mb-7"></div>
								<!--end::Seperator-->
								<!--begin::Section-->
								<div class="mb-10">
									<!--begin::Title-->
									<h5 class="mb-3">Capturar: Empaque</h5>
									<!--end::Title-->
									<!--begin::Details-->
									<div class="mb-0">
										<!--begin::Card info-->
										<button class="btn btn-light-success" id="capture-empaque-btn">Capturar Empaque</button>
										<!--end::Card expiry-->
									</div>
									<!--end::Details-->
								</div>
								<!--end::Section-->
								<!--begin::Actions-->
								<div class="separator separator-dashed mb-7"></div>

								<div class="mb-0">

									<button class="btn btn-primary" id="submit-btn">Submit Photos</button>

								</div>
								<!--end::Actions-->
							</div>
							<!--end::Card body-->
						</div>
						<!--end::Card-->
					</div>
					<!--end::Sidebar-->
				</div>
				<!--end::Layout-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Content wrapper-->
		<!--begin::Footer-->
</div>
		<script src="assets/js/camara.js"></script>

		<?php require('class/footer.php'); ?>