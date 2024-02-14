// Handle previous step
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

// Refactored code
$(document).ready(function () {
	KTJadwal.init();
	// Stepper lement
	var element = document.querySelector("#stepper_jadwal");

	// Initialize Stepper
	var stepper = new KTStepper(element);

	// Handle next step
	stepper.on("kt.stepper.next", function (stepper) {
		stepper.goNext(); // go next step
	});
	stepper.on("kt.stepper.previous", function (stepper) {
		stepper.goPrevious(); // go previous step
	});

	let year = $("input[name='tahun_jadwal']").val();
	let datePrefix = year + "-";
	let defaultDateRange = { from: year + "-01", to: year + "-04" };

	$("select[name='triwulan']").on("change", function () {
		switch ($(this).val()) {
			case "2":
				defaultDateRange = { from: year + "-04", to: year + "-07" };
				break;
			case "3":
				defaultDateRange = { from: year + "-07", to: year + "-10" };
				break;
			case "4":
				defaultDateRange = {
					from: year + "-10",
					to: parseInt(year) + 1 + "-01",
				};
				break;
			default:
				defaultDateRange = { from: year + "-01", to: year + "-04" };
				break;
		}

		$('[data-kt-repeater="tgl_periksa"]').flatpickr({
			defaultDate: defaultDateRange.from,
			enable: [defaultDateRange],
			mode: "range",
		});
	});

	$('[data-kt-repeater="tgl_periksa"]').flatpickr({
		mode: "range",
		minDate: defaultDateRange.from,
		enable: [defaultDateRange],
	});

	$("#repeater_bangunan").repeater({
		repeaters: [
			{
				selector: ".repeater-peralatan",
				show: function () {
					$(this).slideDown();
					$(this)
						.find('[data-kt-repeater="tgl_periksa"]')
						.flatpickr({
							minDate: defaultDateRange.from,
							enable: [defaultDateRange],
							mode: "range",
						});
				},

				hide: function (deleteElement) {
					$(this).slideUp(deleteElement);
				},
				repeaters: [
					{
						selector: ".repeater-item",
						show: function () {
							$(this).slideDown();
							$(this)
								.find('[data-kt-repeater="tgl_periksa"]')
								.flatpickr({
									minDate: defaultDateRange.from,
									enable: [defaultDateRange],
									mode: "range",
								});
						},
						hide: function (deleteElement) {
							$(this).slideUp(deleteElement);
						},
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

	$("#repeater_rawat_bangunan").repeater({
		repeaters: [
			{
				selector: ".repeater-rawat-peralatan",
				show: function () {
					$(this).slideDown();
					$(this)
						.find('[data-kt-repeater="tgl_periksa"]')
						.flatpickr({
							minDate: defaultDateRange.from,
							enable: [defaultDateRange],
							mode: "range",
						});
				},
	
				hide: function (deleteElement) {
					$(this).slideUp(deleteElement);
				},
				repeaters: [
					{
						selector: ".repeater-rawat-item",
						show: function () {
							$(this).slideDown();
							$(this)
								.find('[data-kt-repeater="tgl_periksa"]')
								.flatpickr({
									minDate: defaultDateRange.from,
									enable: [defaultDateRange],
									mode: "range",
								});
						},
						hide: function (deleteElement) {
							$(this).slideUp(deleteElement);
						},
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

	// end ready
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
							toastr.warning(
								"Data item peralatan gagal ditambahkan",
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

function submitFormPemeriksaan(stepper) {
	var formTambahJadwal = document.getElementById(
		"form-tambah-jadwal-elektromekanis"
	);
	formTambahJadwal.addEventListener("submit", function (event) {
		event.preventDefault();
		formTambahJadwal.submit();
	});
	var formData = new FormData(formTambahJadwal);
	$.ajax({
		type: "POST",
		url: hostUrl + "jadwal/elektromekanis/store",
		data: formData,
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function (data) {
		},
		success: function (data) {
			const result = JSON.parse(data);
			$('#kt_jadwal').DataTable().ajax.reload(null, false);
			if (result.status == true) {
				stepper.goNext(); // go next step
			} else {
				toastr.warning(
					"Data item peralatan gagal ditambahkan",
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
		complete: function (data) {
		},
		error: function (data) {
			toastr.error("Terjadi kesalahan sistem.", "Gagal!", {
				timeOut: 2000,
				extendedTimeOut: 0,
				closeButton: true,
				closeDuration: 0,
			});
		},
	});
}
