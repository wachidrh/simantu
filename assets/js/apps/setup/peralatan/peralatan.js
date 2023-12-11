"use strict";

var KTPeralatanList = (function () {
	var t, e, o, n, table;

	return {
		init: function () {
			var url = hostUrl + "setup/peralatan/list";
			table = $("#kt_peralatan_table").DataTable({
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
					emptyTable: "Data peralatan belum tersedia",
					zeroRecords: "Data peralatan tidak ditemukan",
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

			// start tambah master jenis peralatan
			const formTambahPeralatan = document.getElementById("form-tambah-peralatan");
			var valid_form_tambah = FormValidation.formValidation(formTambahPeralatan, {
				framework: "bootstrap",
				fields: {
					id_jenis_peralatan: {
						validators: {
							notEmpty: {
								message: "Nama jenis peralatan harus diisi",
							},
						},
					},
				},
				fields: {
					id_jenis_bangunan: {
						validators: {
							notEmpty: {
								message: "Nama jenis bangunan harus diisi",
							},
						},
					},
				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap5: new FormValidation.plugins.Bootstrap5({
						rowSelector: ".fv-row",
						eleInvalidClass: "",
						eleValidClass: "",
					}),
				},
			});

			const submitSimpanPeralatan = document.getElementById("btn-submit-tambah-peralatan");
			submitSimpanPeralatan.addEventListener("click", function (e) {
				formTambahPeralatan.addEventListener('submit', function(event) {
					event.preventDefault();
					formTambahPeralatan.submit();
				});
				
				if (valid_form_tambah) {
					valid_form_tambah.validate().then(function (status) {
						if (status == "Valid") {
							submitSimpanPeralatan.setAttribute("data-kt-indicator", "on");
							submitSimpanPeralatan.disabled = true;

							var formData = new FormData(formTambahPeralatan);
							$.ajax({
								type: "POST",
								url: hostUrl + "setup/peralatan/store",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitSimpanPeralatan.setAttribute("data-kt-indicator", "on");
									submitSimpanPeralatan.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_add_peralatan").modal("hide");
										Swal.fire({
											text: "Data peratalatan berhasil ditambahkan",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										document.getElementById("form-tambah-peralatan").reset();
									} else {
										toastr.warning("Data peralatan gagal ditambahkan", "Gagal!", {
											timeOut: 2000,
											extendedTimeOut: 0,
											closeButton: true,
											closeDuration: 0,
										});
									}
								},
								complete: function (data) {
									submitSimpanPeralatan.setAttribute("data-kt-indicator", "off");
									submitSimpanPeralatan.disabled = false;
								},
								error: function (data) {
									submitSimpanPeralatan.setAttribute("data-kt-indicator", "off");
									submitSimpanPeralatan.disabled = false;

									toastr.error("Terjadi kesalahan sistem.", "Gagal!", {
										timeOut: 2000,
										extendedTimeOut: 0,
										closeButton: true,
										closeDuration: 0,
									});
								},
							});
						}
					});
				}
			});
			// end tambah master jenis peralatan

			// Edit Asal Pengguna
			$(document).on("click", ".ubah-peralatan", function (e) {
				e.preventDefault();
				var id_peralatan = $(this).attr("data-id");
				
				$.ajax({
					url: hostUrl + "setup/peralatan/lookup",
					type: "POST",
					data: { id_peralatan: id_peralatan },
					dataType: "json",
					beforeSend: function () {
						KTApp.showPageLoading();
					},
					success: function (response) {
						if (response.status == true && Object.keys(response.data).length !== 0) {

							$("[name='edit_id_peralatan']").val(id_peralatan);
							$("[name='edit_id_jenis_peralatan']").val(response.data.id_m_jenis_peralatan).trigger("change");
							$("[name='edit_id_jenis_bangunan']").val(response.data.id_m_jenis_bangunan).trigger("change");
							$("[name='edit_nfc_serial_number']").val(response.data.nfc_serial_number);
			
							$("#modal_edit_peralatan").modal("show");
						} else {
							toastr.error("Terjadi kesalahan saat memuat data.", "Gagal!", {
								timeOut: 2000,
								extendedTimeOut: 0,
								closeButton: true,
								closeDuration: 0,
							});
						}
					},
					complete: function () {
						KTApp.hidePageLoading();
						if ("NDEFReader" in window) { 
							read()
						} else{
							Swal.fire({
								text: "Device tidak support NFC Reader",
								icon: "error",
								confirmButtonColor: "#3085d6",
								confirmButtonText: "Ok",
							});
						}
					},
					error: function () {
						toastr.error("Terjadi kesalahan saat memuat data.", "Gagal!", {
							timeOut: 2000,
							extendedTimeOut: 0,
							closeButton: true,
							closeDuration: 0,
						});
					},
				});
			});	

			const formEditPeralatan = document.getElementById("form-edit-peralatan");
			var valid_update = FormValidation.formValidation(formEditPeralatan, {
				framework: "bootstrap",
				fields: {
					eidt_id_jenis_peralatan: {
						validators: {
							notEmpty: {
								message: "Nama jenis peralatan harus diisi",
							},
						},
					},
				},
				fields: {
					eidt_id_jenis_bangunan: {
						validators: {
							notEmpty: {
								message: "Nama jenis bangunan harus diisi",
							},
						},
					},
				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap5: new FormValidation.plugins.Bootstrap5({
						rowSelector: ".fv-row",
						eleInvalidClass: "",
						eleValidClass: "",
					}),
				},
			});

			const submitUpdatePeralatan = document.getElementById("btn-submit-edit-peralatan");
			submitUpdatePeralatan.addEventListener("click", function (e) {
				formEditPeralatan.addEventListener('submit', function(event) {
					event.preventDefault();
					formEditPeralatan.submit();
				});

				if (valid_update) {
					valid_update.validate().then(function (status) {
						if (status == "Valid") {
							submitUpdatePeralatan.setAttribute("data-kt-indicator", "on");
							submitUpdatePeralatan.disabled = true;

							var formData = new FormData(formEditPeralatan);
							$.ajax({
								type: "POST",
								url: hostUrl + "setup/peralatan/update",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitUpdatePeralatan.setAttribute("data-kt-indicator", "on");
									submitUpdatePeralatan.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_edit_peralatan").modal("hide");
										Swal.fire({
											text: "Data peralatan berhasil diperbarui",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										formEditPeralatan.reset();
									} else {
										toastr.warning("Data peralatan gagal diperbarui", "Gagal!", {
											timeOut: 2000,
											extendedTimeOut: 0,
											closeButton: true,
											closeDuration: 0,
										});
									}
								},
								complete: function (data) {
									submitUpdatePeralatan.setAttribute("data-kt-indicator", "off");
									submitUpdatePeralatan.disabled = false;
								},
								error: function (data) {
									submitUpdatePeralatan.setAttribute("data-kt-indicator", "off");
									submitUpdatePeralatan.disabled = false;

									toastr.error("Terjadi kesalahan sistem.", "Gagal!", {
										timeOut: 2000,
										extendedTimeOut: 0,
										closeButton: true,
										closeDuration: 0,
									});
								},
							});
						}
					});
				}
			});
			// Edit Asal Pengguna

			$(document).on("click", ".hapus-peralatan", function (e) {
				e.preventDefault();

				var id_peralatan = $(this).attr("data-id");

				Swal.fire({
					text: "Apakah Anda yakin ingin menghapus peralatan yang dipilih?",
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
							url: hostUrl + "setup/peralatan/delete",
							type: "POST",
							data: { "id_peralatan[]": id_peralatan },
							beforeSend: function () {
								KTApp.showPageLoading();
							},
							success: function (data) {
								var response = JSON.parse(data);
								if (response.status == true) {
									table.ajax.reload(null, false);
									Swal.fire({
										text: "Anda telah menghapus semua peralatan terpilih!",
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

			// (n = $("#kt_m_peralatan_table")) &&
			// 	((t = table).on("draw", function () {
			// 		r();
			// 		l();
			// 	}),
			// 	r());
		},
	};
})();
function read() {
	const ndef = new NDEFReader();
	ndef.scan().then(() => {
		console.log("Scan started successfully.");
		ndef.onreadingerror = (event) => {
		  console.log("Error! Cannot read data from the NFC tag. Try a different one?");
		};
		ndef.onreading = (event) => {
		  console.log(event.serialNumber);
		  $("[name='nfc_serial_number']").val(event.serialNumber);
		  $("[name='edit_nfc_serial_number']").val(event.serialNumber);
		};
	  }).catch(error => {
		console.log(`Error! Scan failed to start: ${error}.`);
	  });
}

const btnModalTambahPeralatan = document.getElementById("btn-add-peralatan");
btnModalTambahPeralatan.addEventListener("click", function () {
	if ("NDEFReader" in window) { 
		read()
	 } else{
		Swal.fire({
			text: "Device tidak support NFC Reader",
			icon: "error",
			confirmButtonColor: "#3085d6",
			confirmButtonText: "Ok",
		});
	}
});



$(document).ready(function () {
	KTPeralatanList.init();
});
