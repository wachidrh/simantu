$(document).ready(function () {
	$('#setujui_jadwal').click(function () { 
		let data_jadwal = $(this).data('jadwal');
		$.ajax({
			url: hostUrl + "jadwal/elektromekanis/approve",
			type: "POST",
			data: { "id_jadwal": data_jadwal },
			beforeSend: function () {
				KTApp.showPageLoading();
			},
			success: function (data) {
				var response = JSON.parse(data);
				if (response.status == true) {
					Swal.fire({
						text: "Anda telah menyetujui jadwal ini!",
						icon: "success",
						buttonsStyling: false,
						confirmButtonText: "Ok, mengerti!",
						customClass: { confirmButton: "btn fw-bold btn-primary" },
					}).then(function () {
						swal.close();
						window.location.reload();
					});
				} else {
					toastr.error(
						"Terjadi kesalahan saat menyetujui jadwal.",
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
					"Terjadi kesalahan saat menyetujui jadwal.",
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
});
