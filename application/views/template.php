<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<title>SIMANTU Jasa Tirta I - Sistem Monitoring Elektromekanis dan Pantau Ukur</title>
	<meta charset="utf-8" />
	<meta name="description" content="Sistem Monitoring Elektromekanis dan Pantau Ukur Perum Jasa Tirta I">
	<meta name="keywords" content="Sistem Monitoring Elektromekanis dan Pantau Ukur">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="SIMANTU Jasa Tirta I - Sistem Monitoring Elektromekanis dan Pantau Ukur" />
	<meta property="og:url" content="<?php echo base_url(); ?>" />
	<meta property="og:site_name" content="SIMANTU Jasa Tirta I - Sistem Monitoring Elektromekanis dan Pantau Ukur" />
	<link rel="canonical" href="<?php echo base_url(); ?>" />
	<link rel="shortcut icon" href="<?php echo base_url() . 'assets/media/logos/logo-jasatirta-sm.png?time=' . time(); ?>" />

	<link rel=" stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

	<link href="<?php echo base_url() . 'assets/plugins/custom/fullcalendar/fullcalendar.bundle.css'; ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() . 'assets/plugins/custom/datatables/datatables.bundle.css'; ?>" rel="stylesheet" type="text/css" />

	<!-- Font Awesome -->
	<link href="<?php echo base_url() . 'assets/plugins/custom/font-awesome/css/all.css'; ?>" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url() . 'assets/plugins/global/plugins.bundle.css'; ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() . 'assets/css/style.bundle.css'; ?>" rel="stylesheet" type="text/css" />

	<script>
		if (window.top != window.self) {
			window.top.location.replace(window.self.location.href);
		}
	</script>
</head>

<body id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" data-kt-app-page-loading-enabled="true" class="app-default">
	<script>
		var defaultThemeMode = "light";
		var themeMode;

		if (document.documentElement) {
			if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
				themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
			} else {
				if (localStorage.getItem("data-bs-theme") !== null) {
					themeMode = localStorage.getItem("data-bs-theme");
				} else {
					themeMode = defaultThemeMode;
				}
			}

			if (themeMode === "system") {
				themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
			}

			document.documentElement.setAttribute("data-bs-theme", themeMode);
		}
	</script>
	<div class="page-loader flex-column bg-dark bg-opacity-25">
		<span class="spinner-border text-primary" role="status"></span>
		<span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
	</div>
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<div class="app-page  flex-column flex-column-fluid " id="kt_app_page">
			<div id="kt_app_header" class="app-header " data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">

				<div class="app-container  container-fluid d-flex align-items-stretch justify-content-between " id="kt_app_header_container">
					<div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
						<div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
							<i class="ki-outline ki-abstract-14 fs-2 fs-md-1"></i>
						</div>
					</div>
					<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
						<a href="<?php echo base_url(); ?>" class="d-lg-none">
							<img alt="Logo" src="<?php echo base_url() . 'assets/media/logos/logo-jasatirta-sm-dark.png'; ?>" class="h-35px theme-light-show">
							<img alt="Logo" src="<?php echo base_url() . 'assets/media/logos/logo-jasatirta-sm.png'; ?>" class="h-35px theme-dark-show">
						</a>
					</div>
					<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
						<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
							<div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
								<!-- Put Your Navbar Menu Here -->
							</div>
						</div>
						<div class="app-navbar flex-shrink-0">
							<div class="app-navbar-item ms-1 ms-md-4">
								<a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<i class="ki-outline ki-night-day theme-light-show fs-1"></i> <i class="ki-outline ki-moon theme-dark-show fs-1"></i>
								</a>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
											<span class="menu-icon" data-kt-element="icon">
												<i class="ki-outline ki-night-day fs-2"></i> </span>
											<span class="menu-title">
												Light
											</span>
										</a>
									</div>
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
											<span class="menu-icon" data-kt-element="icon">
												<i class="ki-outline ki-moon fs-2"></i> </span>
											<span class="menu-title">
												Dark
											</span>
										</a>
									</div>
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
											<span class="menu-icon" data-kt-element="icon">
												<i class="ki-outline ki-screen fs-2"></i> </span>
											<span class="menu-title">
												System
											</span>
										</a>
									</div>
								</div>
							</div>
							<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
								<div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<img src="<?php echo base_url() . 'assets/media/avatars/300-3.jpg'; ?>" class="rounded-3" alt="user" />
								</div>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
									<div class="menu-item px-3">
										<div class="menu-content d-flex align-items-center px-3">
											<div class="symbol symbol-50px me-5">
												<img alt="Logo" src="<?php echo base_url() . 'assets/media/avatars/300-3.jpg'; ?>" />
											</div>
											<div class="d-flex flex-column">
												<div class="fw-bold d-flex align-items-center fs-5">
													<?php echo $_SESSION['full_name']; ?>
												</div>
												<a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
													<?php echo $_SESSION['email']; ?>
												</a>
											</div>
										</div>
									</div>
									<div class="separator my-2"></div>
									<div class="menu-item px-5">
										<a href="#" class="menu-link px-5">
											My Profile
										</a>
									</div>
									<div class="separator my-2"></div>
									<div class="menu-item px-5">
										<a href="<?php echo base_url() . 'logout'; ?>" class="menu-link px-5">
											Sign Out
										</a>
									</div>
								</div>
							</div>
							<div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
								<div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
									<i class="ki-outline ki-element-4 fs-1"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">
				<div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
					<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
						<a href="<?php echo base_url(); ?>">
							<img alt="Logo" src="<?php echo base_url() . 'assets/media/logos/logo-jasa-tirta-dark.png'; ?>" class=" h-65px app-sidebar-logo-default theme-light-show" />
							<img alt="Logo" src="<?php echo base_url() . 'assets/media/logos/logo-jasa-tirta-white.png'; ?>" class="h-65px app-sidebar-logo-default theme-dark-show" />

							<img alt="Logo" src="<?php echo base_url() . 'assets/media/logos/logo-jasatirta-sm-dark.png'; ?>" class="h-35px app-sidebar-logo-minimize theme-light-show" />
							<img alt="Logo" src="<?php echo base_url() . 'assets/media/logos/logo-jasatirta-sm.png'; ?>" class="h-35px app-sidebar-logo-minimize theme-dark-show" />
						</a>
						<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate " data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">

							<i class="ki-outline ki-black-left-line fs-3 rotate-180"></i>
						</div>
					</div>
					<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
						<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
							<div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
								<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
									<div class="menu-item">
										<a class="menu-link <?php echo $this->uri->segment(1) == 'dashboard' ? 'active' : ''; ?>" href="<?php echo base_url() . 'dashboard'; ?>">
											<span class="menu-icon"><i class="ki-outline ki-element-11 fs-2"></i></span>
											<span class="menu-title">Dashboard</span>
										</a>
									</div>
									<div class="menu-item pt-5">
										<div class="menu-content"><span class="menu-heading fw-bold text-uppercase fs-7">Main</span></div>
									</div>

									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<span class="menu-link">
											<span class="menu-icon"><i class="fa-light fa-gears fs-2"></i>
											</span>
											<span class="menu-title">Settings</span><span class="menu-arrow"></span>
										</span>
										<div class="menu-sub menu-sub-accordion">
											<div class="menu-item">
												<a class="menu-link" href="<?php echo base_url() . '#'; ?>"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Setup Wilayah</span></a>
											</div>
										</div>
									</div>
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion <?= $this->uri->segment(1) == 'master' ? 'show' : ''; ?>">
										<span class="menu-link">
											<span class="menu-icon"><i class="fa-light fa-box fs-2"></i>
											</span>
											<span class="menu-title">Data Master</span><span class="menu-arrow"></span>
										</span>
										<div class="menu-sub menu-sub-accordion">
											<div class="menu-item">
												<a class="menu-link <?= current_url() == base_url('master/peralatan') ? 'active' : ''; ?>" href="<?php echo base_url() . 'master/peralatan'; ?>"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Peralatan</span></a>
											</div>
											<div class="menu-item">
												<a class="menu-link <?= current_url() == base_url('master/item-peralatan') ? 'active' : ''; ?>" href="<?php echo base_url() . 'master/item-peralatan'; ?>"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Item Peralatan</span></a>
											</div>
											<div class="menu-item">
												<a class="menu-link <?= current_url() == base_url('master/kriteria') ? 'active' : ''; ?>" href="<?php echo base_url() . 'master/kriteria'; ?>"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Kriteria Pemeriksaan</span></a>
											</div>
										</div>
									</div>
									<div class="menu-item">
										<a class="menu-link <?= current_url() == base_url('pengguna/list-pengguna') ? 'active' : ''; ?>" href="<?= base_url('pengguna/list-pengguna'); ?>">
											<span class="menu-icon"><i class="ki-outline ki-profile-user fs-2"></i></span>
											<span class="menu-title">Pengguna</span>
										</a>
									</div>

									<div class="menu-item pt-5">
										<div class="menu-content"><span class="menu-heading fw-bold text-uppercase fs-7">Help</span></div>
									</div>
									<div class="menu-item">
										<a class="menu-link" href="#" target="_blank"><span class="menu-icon"><i class="ki-outline ki-code fs-2"></i></span><span class="menu-title">Log Aktivitas</span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
					<!-- Start Content -->
					<?php echo $contents; ?>
					<!-- End Content -->
					<div id="kt_app_footer" class="app-footer ">
						<div class="app-container  container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3 ">
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted fw-semibold me-1">2023 &copy;</span>
								<a href="https://www.jasatirta1.co.id" target="_blank" class="text-gray-800 text-hover-primary">SIMANTU - Perum Jasa Tirta I</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<i class="ki-outline ki-arrow-up"></i>
	</div>
	<script>
		var hostUrl = "<?php echo base_url(); ?>";
	</script>
	<script src="<?php echo base_url() . 'assets/plugins/global/plugins.bundle.js'; ?>"></script>
	<script src="<?php echo base_url() . 'assets/js/scripts.bundle.js'; ?>"></script>

	<script src="<?php echo base_url() . 'assets/plugins/custom/datatables/datatables.bundle.js'; ?>"></script>
	<?php if (isset($javascript) && $javascript != '') { ?>
		<script src="<?php echo base_url() . 'assets/js/apps/' . $javascript; ?>?time=<?php echo time(); ?>"></script>
	<?php } ?>
</body>

</html>
