const formPemeriksaan = document.getElementById(
	"form-pemeriksaan-elektromekanis"
);
const submitPemeriksaan = document.getElementById("btn-submit-pemeriksaan");
submitPemeriksaan.addEventListener("click", function (e) {
	formPemeriksaan.addEventListener("submit", function (event) {
		event.preventDefault();
		formPemeriksaan.submit();
	});

	submitPemeriksaan.setAttribute("data-kt-indicator", "on");
	submitPemeriksaan.disabled = true;

	var formData = new FormData(formPemeriksaan);
	$.ajax({
		type: "POST",
		url: hostUrl + "pemeriksaan/elektromekanis/store",
		data: formData,
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function (data) {
			submitPemeriksaan.setAttribute("data-kt-indicator", "on");
			submitPemeriksaan.disabled = true;
		},
		success: function (data) {
			const result = JSON.parse(data);
			if (result.status == true) {
				Swal.fire({
					text: "Data pemeriksaan berhasil diinput",
					icon: "success",
					confirmButtonColor: "#3085d6",
					confirmButtonText: "Ok",
				});

				setTimeout(function () {
					window.location.href = hostUrl + "/pemeriksaan/elektromekanis";
				}, 2000)
			} else {
				toastr.warning("Data pemeriksaan gagal diinput", "Gagal!", {
					timeOut: 2000,
					extendedTimeOut: 0,
					closeButton: true,
					closeDuration: 0,
				});
			}
		},
		complete: function (data) {
			submitPemeriksaan.setAttribute("data-kt-indicator", "off");
			submitPemeriksaan.disabled = false;
		},
		error: function (data) {
			submitPemeriksaan.setAttribute("data-kt-indicator", "off");
			submitPemeriksaan.disabled = false;

			toastr.error("Terjadi kesalahan sistem.", "Gagal!", {
				timeOut: 2000,
				extendedTimeOut: 0,
				closeButton: true,
				closeDuration: 0,
			});
		},
	});
});
