// $(document).ready(function () {
// 	$('#kt_repeater_bangunan').repeater({
// 		repeaters: [{
// 			selector: '.item-repeater',
// 			show: function () {
// 				$(this).slideDown();
// 			},
	
// 			hide: function (deleteElement) {
// 				$(this).slideUp(deleteElement);
// 			}
// 		}],
	
// 		show: function () {
// 			$(this).slideDown();
// 		},
	
// 		hide: function (deleteElement) {
// 			$(this).slideUp(deleteElement);
// 		}
// 	});
	
// })

// const formPemeriksaan = document.getElementById(
// 	"form-pemeriksaan-elektromekanis"
// );
// const submitPemeriksaan = document.getElementById("btn-submit-pemeriksaan");
// submitPemeriksaan.addEventListener("click", function (e) {
// 	formPemeriksaan.addEventListener("submit", function (event) {
// 		event.preventDefault();
// 		formPemeriksaan.submit();
// 	});

// 	submitPemeriksaan.setAttribute("data-kt-indicator", "on");
// 	submitPemeriksaan.disabled = true;

// 	var formData = new FormData(formPemeriksaan);
// 	$.ajax({
// 		type: "POST",
// 		url: hostUrl + "pemeriksaan/elektromekanis/store",
// 		data: formData,
// 		contentType: false,
// 		cache: false,
// 		processData: false,
// 		beforeSend: function (data) {
// 			submitPemeriksaan.setAttribute("data-kt-indicator", "on");
// 			submitPemeriksaan.disabled = true;
// 		},
// 		success: function (data) {
// 			const result = JSON.parse(data);
// 			if (result.status == true) {
// 				Swal.fire({
// 					text: "Data pemeriksaan berhasil diinput",
// 					icon: "success",
// 					confirmButtonColor: "#3085d6",
// 					confirmButtonText: "Ok",
// 				});

// 				setTimeout(function () {
// 					window.location.href = window.location.origin + "/pemeriksaan/elektromekanis";
// 				}, 2000)
// 			} else {
// 				toastr.warning("Data pemeriksaan gagal diinput", "Gagal!", {
// 					timeOut: 2000,
// 					extendedTimeOut: 0,
// 					closeButton: true,
// 					closeDuration: 0,
// 				});
// 			}
// 		},
// 		complete: function (data) {
// 			submitPemeriksaan.setAttribute("data-kt-indicator", "off");
// 			submitPemeriksaan.disabled = false;
// 		},
// 		error: function (data) {
// 			submitPemeriksaan.setAttribute("data-kt-indicator", "off");
// 			submitPemeriksaan.disabled = false;

// 			toastr.error("Terjadi kesalahan sistem.", "Gagal!", {
// 				timeOut: 2000,
// 				extendedTimeOut: 0,
// 				closeButton: true,
// 				closeDuration: 0,
// 			});
// 		},
// 	});
// });

$(".cek-jadwal").click(function () {
	let periode = $(this).data("periode");
	let id_bangunan = $(this).data("id-bangunan");
	let id_peralatan = $(this).data("id-peralatan");

	$.ajax({
		url: hostUrl + "pemeriksaan/elektromekanis/cek-jadwal",
		type: "POST",
		data: {
			id_bangunan : id_bangunan,
			periode: periode,
			id_peralatan : id_peralatan,
		},
		beforeSend: function () {
			KTApp.showPageLoading();
		},
		success: function (data) {
			var response = JSON.parse(data);
			if (response.status == true) {
				window.location.href = hostUrl + response.messages;
			} else {
				toastr.error(
					"Jadwal tidak tersedia, silakan pilih periode lain.",
					"Gagal!",
					{
						timeOut: 2000,
						extendedTimeOut: 0,
						closeButton: true,
						closeDuration: 0,
					}
				);
			}
		},
		complete: function () {
			KTApp.hidePageLoading();
		},
		error: function () {
			toastr.error(
				"Terjadi kesalahan saat pengecekan jadwal.",
				"Gagal!",
				{
					timeOut: 2000,
					extendedTimeOut: 0,
					closeButton: true,
					closeDuration: 0,
				}
			);
		},
	});
})
