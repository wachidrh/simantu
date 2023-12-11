"use strict";

var KTMPeralatanList = (function () {
	var t, e, o, n, table;

	return {
		init: function () {
			var url = hostUrl + "master/bangunan/list";
			table = $("#kt_m_bangunan_table").DataTable({
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
					emptyTable: "Data master jenis belum tersedia",
					zeroRecords: "Data master jenis tidak ditemukan",
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

			// start tambah master jenis bangunan
			const formTambahMBangunan = document.getElementById("form-tambah-m-bangunan");
			var valid_form_tambah = FormValidation.formValidation(formTambahMBangunan, {
				framework: "bootstrap",
				fields: {
					nama_bangunan: {
						validators: {
							notEmpty: {
								message: "Jenis bangunan harus diisi",
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

			const submitSimpanMBangunan = document.getElementById("btn-submit-tambah-m-bangunan");
			submitSimpanMBangunan.addEventListener("click", function (e) {
				formTambahMBangunan.addEventListener('submit', function(event) {
					event.preventDefault();
					formTambahMBangunan.submit();
				});
				
				if (valid_form_tambah) {
					valid_form_tambah.validate().then(function (status) {
						if (status == "Valid") {
							submitSimpanMBangunan.setAttribute("data-kt-indicator", "on");
							submitSimpanMBangunan.disabled = true;

							var formData = new FormData(formTambahMBangunan);
							$.ajax({
								type: "POST",
								url: hostUrl + "master/bangunan/store",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitSimpanMBangunan.setAttribute("data-kt-indicator", "on");
									submitSimpanMBangunan.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_add_bangunan").modal("hide");
										Swal.fire({
											text: "Data jenis bangunan berhasil ditambahkan",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										formTambahMBangunan.reset();
									} else {
										toastr.warning("Data jenis bangunan gagal ditambahkan", "Gagal!", {
											timeOut: 2000,
											extendedTimeOut: 0,
											closeButton: true,
											closeDuration: 0,
										});
									}
								},
								complete: function (data) {
									submitSimpanMBangunan.setAttribute("data-kt-indicator", "off");
									submitSimpanMBangunan.disabled = false;
								},
								error: function (data) {
									submitSimpanMBangunan.setAttribute("data-kt-indicator", "off");
									submitSimpanMBangunan.disabled = false;

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
			$(document).on("click", ".ubah-bangunan", function (e) {
				e.preventDefault();
				var id_jenis_bangunan = $(this).attr("data-id");
				
				$.ajax({
					url: hostUrl + "master/bangunan/lookup",
					type: "POST",
					data: { id_jenis_bangunan: id_jenis_bangunan },
					dataType: "json",
					beforeSend: function () {
						KTApp.showPageLoading();
					},
					success: function (response) {
						if (response.status == true && Object.keys(response.data).length !== 0) {

							$("[name='edit_id_jenis_bangunan']").val(id_jenis_bangunan);
							$("[name='edit_nama_bangunan']").val(response.data.nama_bangunan);
			
							$("#modal_edit_bangunan").modal("show");
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

			const formEditBangunan = document.getElementById("form-edit-m-bangunan");
			var valid_update = FormValidation.formValidation(formEditBangunan, {
				framework: "bootstrap",
				fields: {
					edit_nama_bangunan: {
						validators: {
							notEmpty: {
								message: "Jenis bangunan harus diisi",
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

			const submitUpdateMBangunan = document.getElementById("btn-submit-edit-m-bangunan");
			submitUpdateMBangunan.addEventListener("click", function (e) {
				formEditBangunan.addEventListener('submit', function(event) {
					event.preventDefault();
					formEditBangunan.submit();
				});

				if (valid_update) {
					valid_update.validate().then(function (status) {
						if (status == "Valid") {
							submitUpdateMBangunan.setAttribute("data-kt-indicator", "on");
							submitUpdateMBangunan.disabled = true;

							var formData = new FormData(formEditBangunan);
							$.ajax({
								type: "POST",
								url: hostUrl + "master/bangunan/update",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitUpdateMBangunan.setAttribute("data-kt-indicator", "on");
									submitUpdateMBangunan.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_edit_bangunan").modal("hide");
										Swal.fire({
											text: "Data jenis bangunan berhasil diperbarui",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										formEditBangunan.reset();
									} else {
										toastr.warning("Data jenis bangunan gagal diperbarui", "Gagal!", {
											timeOut: 2000,
											extendedTimeOut: 0,
											closeButton: true,
											closeDuration: 0,
										});
									}
								},
								complete: function (data) {
									submitUpdateMBangunan.setAttribute("data-kt-indicator", "off");
									submitUpdateMBangunan.disabled = false;
								},
								error: function (data) {
									submitUpdateMBangunan.setAttribute("data-kt-indicator", "off");
									submitUpdateMBangunan.disabled = false;

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

			$(document).on("click", ".hapus-bangunan", function (e) {
				e.preventDefault();

				var id_jenis_bangunan = $(this).attr("data-id");

				Swal.fire({
					text: "Apakah Anda yakin ingin menghapus jenis bangunan yang dipilih?",
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
							url: hostUrl + "master/bangunan/delete",
							type: "POST",
							data: { "id_jenis_bangunan[]": id_jenis_bangunan },
							beforeSend: function () {
								KTApp.showPageLoading();
							},
							success: function (data) {
								var response = JSON.parse(data);
								if (response.status == true) {
									table.ajax.reload(null, false);
									Swal.fire({
										text: "Anda telah menghapus semua jenis bangunan terpilih!",
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
