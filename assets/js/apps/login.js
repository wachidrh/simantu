"use strict";

var KTSigninGeneral = (function () {
	var form;
	var submitButton;
	var validator;

	var handleValidation = function (e) {
		validator = FormValidation.formValidation(form, {
			fields: {
				kopeg: {
					validators: {
						notEmpty: {
							message: "Kode pegawai harus diisi",
						},
					},
				},
				password: {
					validators: {
						notEmpty: {
							message: "Kata sandi harus diisi",
						},
					},
				},
			},
			plugins: {
				trigger: new FormValidation.plugins.Trigger(),
				bootstrap: new FormValidation.plugins.Bootstrap5({
					rowSelector: ".fv-row",
					eleInvalidClass: "",
					eleValidClass: "",
				}),
			},
		});
	};

	var handleSubmitAjax = function (e) {
		submitButton.addEventListener("click", function (e) {
			e.preventDefault();

			validator.validate().then(function (status) {
				if (status == "Valid") {
					submitButton.setAttribute("data-kt-indicator", "on");
					submitButton.disabled = true;

					var formdata = new FormData(form);
					axios
						.post(hostname + "login/submit", formdata)
						.then(function (response) {
							if (response.data.status != true) {
								submitButton.removeAttribute("data-kt-indicator");
								submitButton.disabled = false;
							}

							if (response.data.status == true) {
								toastr.success(
									response.data.messages,
									"Berhasil!",
									{
										extendedTimeOut: 0,
										closeButton: false,
										closeDuration: 0,
									}
								);
								window.location.href = hostname + "dashboard";
							} else if (response.data.status == "blocked") {
								toastr.error(response.data.messages, "Gagal!", {
									timeOut: 5000,
									extendedTimeOut: 0,
									closeButton: false,
									closeDuration: 0,
								});
								grecaptcha.reset();
							} else {
								toastr.warning(
									response.data.messages,
									"Gagal!",
									{
										timeOut: 5000,
										extendedTimeOut: 0,
										closeButton: false,
										closeDuration: 0,
									}
								);
								grecaptcha.reset();
							}
						})
						.catch(function (error) {
							submitButton.removeAttribute("data-kt-indicator");
							submitButton.disabled = false;

							toastr.error(
								"System mengalami gangguan. Hubungi Administrator.",
								"Gagal!",
								{
									timeOut: 2000,
									extendedTimeOut: 0,
									closeButton: false,
									closeDuration: 0,
								}
							);
						});
				}
			});
		});
	};

	return {
		init: function () {
			form = document.querySelector("#form-signin");
			submitButton = document.querySelector("#btn-submit");

			handleValidation();
			handleSubmitAjax();
		},
	};
})();

KTUtil.onDOMContentLoaded(function () {
	KTSigninGeneral.init();
});
