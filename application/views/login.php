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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="<?php echo base_url() . 'assets/plugins/global/plugins.bundle.css'; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() . 'assets/css/style.bundle.css'; ?>" rel="stylesheet" type="text/css" />
    <style>
        .grecaptcha-badge {
            visibility: hidden;
        }
    </style>

    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body id="kt_body" class="app-blank">
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
    <div class="d-flex flex-column flex-root" id="kt_app_root">

        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <a href="<?php echo base_url(); ?>" class="d-block d-lg-none mx-auto py-15 py-md-10">
                <img alt="Logo" src="<?php echo base_url() . 'assets/media/logos/logo-jasa-tirta.png'; ?>" class="theme-light-show h-80px" />
                <img alt="Logo" src="<?php echo base_url() . 'assets/media/logos/logo-jasa-tirta.png'; ?>" class="theme-dark-show h-80px" />
            </a>
            <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat" style="background-image: url('<?php echo base_url() . 'assets/media/auth/bg-login.png?time=' . time(); ?>')">
            </div>
            <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 px-10">
                <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                    <div class="py-5 py-md-5 py-xl-20">
                        <form method="POST" class="form w-100" id="form-signin">
                            <div class="card-body">
                                <div class="text-start mb-10">
                                    <h1 class="text-dark mb-3 fs-1x" data-kt-translate="sign-in-title">
                                        Selamat Datang
                                    </h1>
                                    <div class="text-gray-400 fw-semibold fs-6" data-kt-translate="general-desc">
                                        Silakan masuk untuk melanjutkan.
                                    </div>
                                </div>
                                <div class="fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">Kode Pegawai</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg form-control-solid" name="kopeg" placeholder="" value="">
                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                                <div class="fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid" data-kt-password-meter="true">
                                    <div class="mb-1">
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">Kata Sandi</span>
                                        </label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off" />
                                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row mb-8">
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="remember-me" />
                                        <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                                            Ingat Saya
                                        </span>
                                    </label>
                                </div>
                                <div class="fv-row mb-8">
                                    <?php echo $recaptcha; ?>
                                </div>
                                <div class="d-flex flex-stack">
                                    <button type="submit" id="btn-submit" class="btn btn-primary me-2 flex-shrink-0">
                                        <span class="indicator-label" data-kt-translate="sign-in-submit">
                                            Masuk
                                        </span>
                                        <span class="indicator-progress">
                                            <span data-kt-translate="general-progress">Harap tunggu...</span>
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var hostname = "<?php echo base_url(); ?>";
    </script>
    <script src="<?php echo base_url() . 'assets/plugins/global/plugins.bundle.js'; ?>"></script>
    <script src="<?php echo base_url() . 'assets/js/scripts.bundle.js'; ?>"></script>
    <script src="<?php echo base_url() . 'assets/js/apps/login.js'; ?>?time=<?php echo time(); ?>"></script>
</body>

</html>