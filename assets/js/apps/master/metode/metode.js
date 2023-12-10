"use strict";

var KTMPeralatanList = (function () {
	var t, e, o, n, table;

	return {
		init: function () {
			var url = hostUrl + "master/metode/list";
			table = $("#kt_m_metode_table").DataTable({
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
					emptyTable: "Data master peralatan belum tersedia",
					zeroRecords: "Data master peralatan tidak ditemukan",
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
					}
				],

				dom: '<"top"l>rt<"bottom left"pi><"caption right"><"clear">',
			});

			$("#search").keyup(function (event) {
				table.ajax.reload(null, false);
			});

			// start tambah master metode pemeriksaan
			const formTambahMMetode = document.getElementById("form-tambah-m-metode");
			var valid_form_tambah = FormValidation.formValidation(formTambahMMetode, {
				framework: "bootstrap",
				fields: {
					metode: {
						validators: {
							notEmpty: {
								message: "Metode pemeriksaan harus diisi",
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

			const submitSimpanMMetode = document.getElementById("btn-submit-tambah-m-metode");
			submitSimpanMMetode.addEventListener("click", function (e) {
				formTambahMMetode.addEventListener('submit', function(event) {
					event.preventDefault();
					formTambahMMetode.submit();
				});
				
				if (valid_form_tambah) {
					valid_form_tambah.validate().then(function (status) {
						if (status == "Valid") {
							submitSimpanMMetode.setAttribute("data-kt-indicator", "on");
							submitSimpanMMetode.disabled = true;

							var formData = new FormData(formTambahMMetode);
							$.ajax({
								type: "POST",
								url: hostUrl + "master/metode/store",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitSimpanMMetode.setAttribute("data-kt-indicator", "on");
									submitSimpanMMetode.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_add_metode").modal("hide");
										Swal.fire({
											text: "Data metode pemeriksaan berhasil ditambahkan",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										formTambahMMetode.reset();
									} else {
										toastr.warning("Data metode pemeriksaan gagal ditambahkan", "Gagal!", {
											timeOut: 2000,
											extendedTimeOut: 0,
											closeButton: true,
											closeDuration: 0,
										});
									}
								},
								complete: function (data) {
									submitSimpanMMetode.setAttribute("data-kt-indicator", "off");
									submitSimpanMMetode.disabled = false;
								},
								error: function (data) {
									submitSimpanMMetode.setAttribute("data-kt-indicator", "off");
									submitSimpanMMetode.disabled = false;

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
			// end tambah master metode pemeriksaan

			// Edit Asal Pengguna
			$(document).on("click", ".ubah-metode", function (e) {
				e.preventDefault();
				var id_metode = $(this).attr("data-id");
				
				$.ajax({
					url: hostUrl + "master/metode/lookup",
					type: "POST",
					data: { id_metode: id_metode },
					dataType: "json",
					beforeSend: function () {
						KTApp.showPageLoading();
					},
					success: function (response) {
						if (response.status == true && Object.keys(response.data).length !== 0) {

							$("[name='edit_id_metode']").val(id_metode);
							$("[name='edit_metode']").val(response.data.metode);
			
							$("#modal_edit_metode").modal("show");
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

			const formEditMetode = document.getElementById("form-edit-m-metode");
			var valid_update = FormValidation.formValidation(formEditMetode, {
				framework: "bootstrap",
				fields: {
					edit_metode: {
						validators: {
							notEmpty: {
								message: "Metode pemeriksaan harus diisi",
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

			const submitUpdateMMetode = document.getElementById("btn-submit-edit-m-metode");
			submitUpdateMMetode.addEventListener("click", function (e) {
				formEditMetode.addEventListener('submit', function(event) {
					event.preventDefault();
					formEditMetode.submit();
				});

				if (valid_update) {
					valid_update.validate().then(function (status) {
						if (status == "Valid") {
							submitUpdateMMetode.setAttribute("data-kt-indicator", "on");
							submitUpdateMMetode.disabled = true;

							var formData = new FormData(formEditMetode);
							$.ajax({
								type: "POST",
								url: hostUrl + "master/metode/update",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitUpdateMMetode.setAttribute("data-kt-indicator", "on");
									submitUpdateMMetode.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_edit_metode").modal("hide");
										Swal.fire({
											text: "Data metode pemeriksaan berhasil diperbarui",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										formEditMetode.reset();
									} else {
										toastr.warning("Data metode pemeriksaan gagal diperbarui", "Gagal!", {
											timeOut: 2000,
											extendedTimeOut: 0,
											closeButton: true,
											closeDuration: 0,
										});
									}
								},
								complete: function (data) {
									submitUpdateMMetode.setAttribute("data-kt-indicator", "off");
									submitUpdateMMetode.disabled = false;
								},
								error: function (data) {
									submitUpdateMMetode.setAttribute("data-kt-indicator", "off");
									submitUpdateMMetode.disabled = false;

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

			$(document).on("click", ".hapus-metode", function (e) {
				e.preventDefault();

				var id_metode = $(this).attr("data-id");

				Swal.fire({
					text: "Apakah Anda yakin ingin menghapus metode pemeriksaan yang dipilih?",
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
							url: hostUrl + "master/metode/delete",
							type: "POST",
							data: { "id_metode[]": id_metode },
							beforeSend: function () {
								KTApp.showPageLoading();
							},
							success: function (data) {
								var response = JSON.parse(data);
								if (response.status == true) {
									table.ajax.reload(null, false);
									Swal.fire({
										text: "Anda telah menghapus semua metode pemeriksaan terpilih!",
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

$(document).ready(function () {
	KTMPeralatanList.init();
});
