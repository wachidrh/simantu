"use strict";

var KTMPeralatanList = (function () {
	var t, e, o, n, table;

	return {
		init: function () {
			var url = hostUrl + "master/kriteria/list";
			table = $("#kt_m_kriteria_table").DataTable({
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

			// start tambah master kriteria pemeriksaan
			const formTambahMKriteria = document.getElementById("form-tambah-m-kriteria");
			var valid_form_tambah = FormValidation.formValidation(formTambahMKriteria, {
				framework: "bootstrap",
				fields: {
					kriteria: {
						validators: {
							notEmpty: {
								message: "Kriteria pemeriksaan harus diisi",
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

			const submitSimpanMKriteria = document.getElementById("btn-submit-tambah-m-kriteria");
			submitSimpanMKriteria.addEventListener("click", function (e) {
				formTambahMKriteria.addEventListener('submit', function(event) {
					event.preventDefault();
					formTambahMKriteria.submit();
				});
				
				if (valid_form_tambah) {
					valid_form_tambah.validate().then(function (status) {
						if (status == "Valid") {
							submitSimpanMKriteria.setAttribute("data-kt-indicator", "on");
							submitSimpanMKriteria.disabled = true;

							var formData = new FormData(formTambahMKriteria);
							$.ajax({
								type: "POST",
								url: hostUrl + "master/kriteria/store",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitSimpanMKriteria.setAttribute("data-kt-indicator", "on");
									submitSimpanMKriteria.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_add_kriteria").modal("hide");
										Swal.fire({
											text: "Data kriteria pemeriksaan berhasil ditambahkan",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										formTambahMKriteria.reset();
									} else {
										toastr.warning("Data kriteria pemeriksaan gagal ditambahkan", "Gagal!", {
											timeOut: 2000,
											extendedTimeOut: 0,
											closeButton: true,
											closeDuration: 0,
										});
									}
								},
								complete: function (data) {
									submitSimpanMKriteria.setAttribute("data-kt-indicator", "off");
									submitSimpanMKriteria.disabled = false;
								},
								error: function (data) {
									submitSimpanMKriteria.setAttribute("data-kt-indicator", "off");
									submitSimpanMKriteria.disabled = false;

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
			$(document).on("click", ".ubah-kriteria", function (e) {
				e.preventDefault();
				var id_kriteria = $(this).attr("data-id");
				
				$.ajax({
					url: hostUrl + "master/kriteria/lookup",
					type: "POST",
					data: { id_kriteria: id_kriteria },
					dataType: "json",
					beforeSend: function () {
						KTApp.showPageLoading();
					},
					success: function (response) {
						if (response.status == true && Object.keys(response.data).length !== 0) {

							$("[name='edit_id_kriteria']").val(id_kriteria);
							$("[name='edit_kriteria']").val(response.data.kriteria);
			
							$("#modal_edit_kriteria").modal("show");
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

			const formEditJenisKriteria = document.getElementById("form-edit-m-kriteria");
			var valid_update = FormValidation.formValidation(formEditJenisKriteria, {
				framework: "bootstrap",
				fields: {
					edit_nama_jenis_peralatan: {
						validators: {
							notEmpty: {
								message: "Kriteria pemeriksaan harus diisi",
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

			const submitUpdateMKriteria = document.getElementById("btn-submit-edit-m-kriteria");
			submitUpdateMKriteria.addEventListener("click", function (e) {
				formEditJenisKriteria.addEventListener('submit', function(event) {
					event.preventDefault();
					formEditJenisKriteria.submit();
				});

				if (valid_update) {
					valid_update.validate().then(function (status) {
						if (status == "Valid") {
							submitUpdateMKriteria.setAttribute("data-kt-indicator", "on");
							submitUpdateMKriteria.disabled = true;

							var formData = new FormData(formEditJenisKriteria);
							$.ajax({
								type: "POST",
								url: hostUrl + "master/kriteria/update",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitUpdateMKriteria.setAttribute("data-kt-indicator", "on");
									submitUpdateMKriteria.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_edit_kriteria").modal("hide");
										Swal.fire({
											text: "Data kriteria pemeriksaan berhasil diperbarui",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										formEditJenisKriteria.reset();
									} else {
										toastr.warning("Data pengguna gagal diperbarui", "Gagal!", {
											timeOut: 2000,
											extendedTimeOut: 0,
											closeButton: true,
											closeDuration: 0,
										});
									}
								},
								complete: function (data) {
									submitUpdateMKriteria.setAttribute("data-kt-indicator", "off");
									submitUpdateMKriteria.disabled = false;
								},
								error: function (data) {
									submitUpdateMKriteria.setAttribute("data-kt-indicator", "off");
									submitUpdateMKriteria.disabled = false;

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

			$(document).on("click", ".hapus-kriteria", function (e) {
				e.preventDefault();

				var id_kriteria = $(this).attr("data-id");

				Swal.fire({
					text: "Apakah Anda yakin ingin menghapus kriteria pemeriksaan yang dipilih?",
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
							url: hostUrl + "master/kriteria/delete",
							type: "POST",
							data: { "id_kriteria[]": id_kriteria },
							beforeSend: function () {
								KTApp.showPageLoading();
							},
							success: function (data) {
								var response = JSON.parse(data);
								if (response.status == true) {
									table.ajax.reload(null, false);
									Swal.fire({
										text: "Anda telah menghapus semua kriteria pemeriksaan terpilih!",
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
