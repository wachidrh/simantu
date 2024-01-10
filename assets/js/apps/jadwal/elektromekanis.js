new tempusDominus.TempusDominus(document.getElementById("dt_picker_tahun"), {
	display: {
		viewMode: "calendar",
		components: {
			decades: false,
			year: true,
			month: false,
			date: false,
			hours: false,
			minutes: false,
			seconds: false,
		},
	},
	localization: {
		format: "yyyy",
	},
});

new tempusDominus.TempusDominus(document.getElementById("dt_picker_tahun"), {
	display: {
		viewMode: "calendar",
		components: {
			decades: false,
			year: true,
			month: false,
			date: false,
			hours: false,
			minutes: false,
			seconds: false,
		},
	},
	localization: {
		format: "yyyy",
	},
});

$(document).ready(function () {
	KTJadwal.init();
	$('[data-kt-repeater="tgl_periksa"]').flatpickr();
	$("#repeater_bangunan").repeater({
		repeaters: [
			{
				selector: ".repeater-peralatan",
				show: function () {
					$(this).slideDown();
					$(this).find('[data-kt-repeater="tgl_periksa"]').flatpickr();
				},

				hide: function (deleteElement) {
					$(this).slideUp(deleteElement);
				},
				repeaters: [
					{
						// Second level of nesting
						selector: ".repeater-item",
						show: function () {
							$(this).slideDown();
							$(this).find('[data-kt-repeater="tgl_periksa"]').flatpickr();
						},
						hide: function (deleteElement) {
							$(this).slideUp(deleteElement);
						},
						// Add more levels of nesting if needed
					},
				],
			},
		],

		show: function () {
			$(this).slideDown();
			$(this).find('[data-kt-repeater="tgl_periksa"]').flatpickr();
		},

		hide: function (deleteElement) {
			$(this).slideUp(deleteElement);
		},
	});
});

var KTJadwal = (function () {
	var t, e, o, n, table;

	return {
		init: function () {
			var url = hostUrl + "jadwal/elektromekanis/list";
			table = $("#kt_jadwal").DataTable({
				responsive: true,
				processing: true,
				serverSide: true,
				order: [],
				searching: true,
				info: false,
				pagingType: "full_numbers",
				bLengthChange: false,
				bPaginate: true,
				bProcessing: false,
				language: {
					emptyTable: "Data jadwal pemeriksaan belum tersedia",
					zeroRecords: "Data jadwal pemeriksaan tidak ditemukan",
					paginate: {
						previous: "<i class='fa fa-angle-left' aria-hidden='true'></i>",
						next: " <i class='fa fa-angle-right' aria-hidden='true'></i> ",
						first:
							"<i class='fa fa-angle-double-left' aria-hidden='true'></i> ",
						last: "<i class='fa fa-angle-double-right' aria-hidden='true'></i> ",
					},
				},
				dom: '<"top"l>rt<"bottom left"pi><"caption right"><"clear">',
				ajax: {
					url: url,
					type: "POST",
					data: function (data) {
						data.search = $("#search").val();
					},
				},
				fnPreDrawCallback: function () {
					$("tbody").html("");
				},
				columnDefs: [
					{
						targets: [0],
						orderable: true,
						class: "align-top",
					},
					{
						targets: [1],
						orderable: true,
						class: "align-top",
					},
					{
						targets: [2],
						orderable: false,
						class: "align-top",
					},
					{
						targets: [3],
						orderable: false,
						class: "align-top",
					},
					{
						targets: [4],
						orderable: false,
						class: "align-top",
					},
				],

				dom: '<"top"l>rt<"bottom left"pi><"caption right"><"clear">',
			});

			$("#search").keyup(function (event) {
				table.ajax.reload(null, false);
			});

			const formTambahJadwal = document.getElementById(
				"form-tambah-jadwal-elektromekanis"
			);
			const submitJadwal = document.getElementById("btn-submit-jadwal");
			submitJadwal.addEventListener("click", function (e) {
				formTambahJadwal.addEventListener("submit", function (event) {
					event.preventDefault();
					formTambahJadwal.submit();
				});
			
				submitJadwal.setAttribute("data-kt-indicator", "on");
				submitJadwal.disabled = true;
			
				var formData = new FormData(formTambahJadwal);
				$.ajax({
					type: "POST",
					url: hostUrl + "jadwal/elektromekanis/store",
					data: formData,
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function (data) {
						submitJadwal.setAttribute("data-kt-indicator", "on");
						submitJadwal.disabled = true;
					},
					success: function (data) {
						const result = JSON.parse(data);
						table.ajax.reload(null, false);
						if (result.status == true) {
							$("#modal_generate_jadwal").modal("hide");
							Swal.fire({
								text: "Data item peralatan berhasil ditambahkan",
								icon: "success",
								confirmButtonColor: "#3085d6",
								confirmButtonText: "Ok",
							});
			
							formTambahJadwal.reset();
						} else {
							toastr.warning("Data item peralatan gagal ditambahkan", "Gagal!", {
								timeOut: 2000,
								extendedTimeOut: 0,
								closeButton: true,
								closeDuration: 0,
							});
						}
					},
					complete: function (data) {
						submitJadwal.setAttribute("data-kt-indicator", "off");
						submitJadwal.disabled = false;
					},
					error: function (data) {
						submitJadwal.setAttribute("data-kt-indicator", "off");
						submitJadwal.disabled = false;
			
						toastr.error("Terjadi kesalahan sistem.", "Gagal!", {
							timeOut: 2000,
							extendedTimeOut: 0,
							closeButton: true,
							closeDuration: 0,
						});
					},
				});
			});

			$(document).on("click", ".hapus-jadwal", function (e) {
				e.preventDefault();

				var id_item_peralatan = $(this).attr("data-id");

				Swal.fire({
					text: "Apakah Anda yakin ingin menghapus item peralatan yang dipilih?",
					icon: "warning",
					showCancelButton: true,
					buttonsStyling: false,
					confirmButtonText: "Ya, hapus!",
					cancelButtonText: "Batal",
					customClass: {
						confirmButton: "btn fw-bold btn-danger",
						cancelButton: "btn fw-bold btn-active-light-primary",
					},
				}).then(function (result) {
					if (result.isConfirmed) {
						$.ajax({
							url: hostUrl + "master/item-peralatan/delete",
							type: "POST",
							data: { "id_item_peralatan[]": id_item_peralatan },
							beforeSend: function () {
								KTApp.showPageLoading();
							},
							success: function (data) {
								var response = JSON.parse(data);
								table.ajax.reload(null, false);
								if (response.status == true) {
									table.ajax.reload(null, false);
									Swal.fire({
										text: "Anda telah menghapus semua item peralatan terpilih!",
										icon: "success",
										buttonsStyling: false,
										confirmButtonText: "Ok, mengerti!",
										customClass: { confirmButton: "btn fw-bold btn-primary" },
									}).then(function () {
										swal.close();
									});
								} else {
									toastr.error(
										"Terjadi kesalahan saat menghapus data.",
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
									"Terjadi kesalahan saat menghapus data.",
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
					}
				});
			});

			// (n = $("#kt_jadwal")) &&
			// 	((t = table).on("draw", function () {
			// 		r();
			// 		l();
			// 	}),
			// 	r());
		},
	};
})();
