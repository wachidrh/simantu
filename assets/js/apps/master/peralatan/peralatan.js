"use strict";

var KTMPeralatanList = (function () {
	var t, e, o, n, table;

	return {
		init: function () {
			var url = hostUrl + "master/peralatan/get-master-peralatan";
			table = $("#kt_m_peralatan_table").DataTable({
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

			// start tambah master jenis peralatan
			const formTambahMPeralatan = document.getElementById("form-tambah-m-jenis-peralatan");
			var valid_form_tambah = FormValidation.formValidation(formTambahMPeralatan, {
				framework: "bootstrap",
				fields: {
					nama_jenis_peralatan: {
						validators: {
							notEmpty: {
								message: "Nama jenis peralatan harus diisi",
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

			const submitSimpanMJenisPeralatan = document.getElementById("btn-submit-tambah-m-jenis-peralatan");
			submitSimpanMJenisPeralatan.addEventListener("click", function (e) {
				formTambahMPeralatan.addEventListener('submit', function(event) {
					event.preventDefault();
					formTambahMPeralatan.submit();
				});
				
				if (valid_form_tambah) {
					valid_form_tambah.validate().then(function (status) {
						if (status == "Valid") {
							submitSimpanMJenisPeralatan.setAttribute("data-kt-indicator", "on");
							submitSimpanMJenisPeralatan.disabled = true;

							var formData = new FormData(formTambahMPeralatan);
							console.log(formData);
							$.ajax({
								type: "POST",
								url: hostUrl + "master/peralatan/store",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitSimpanMJenisPeralatan.setAttribute("data-kt-indicator", "on");
									submitSimpanMJenisPeralatan.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_add_peralatan").modal("hide");
										Swal.fire({
											text: "Data Pengguna berhasil ditambahkan",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										document.getElementById("form-tambah-m-jenis-peralatan").reset();
									} else {
										toastr.warning("Data Pengguna gagal ditambahkan", "Gagal!", {
											timeOut: 2000,
											extendedTimeOut: 0,
											closeButton: true,
											closeDuration: 0,
										});
									}
								},
								complete: function (data) {
									submitSimpanMJenisPeralatan.setAttribute("data-kt-indicator", "off");
									submitSimpanMJenisPeralatan.disabled = false;
								},
								error: function (data) {
									submitSimpanMJenisPeralatan.setAttribute("data-kt-indicator", "off");
									submitSimpanMJenisPeralatan.disabled = false;

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
			$(document).on("click", ".ubah-jenis-peralatan", function (e) {
				e.preventDefault();
				var id_jenis_peralatan = $(this).attr("data-id");
				
				$.ajax({
					url: hostUrl + "master/peralatan/lookup",
					type: "POST",
					data: { id_jenis_peralatan: id_jenis_peralatan },
					dataType: "json",
					beforeSend: function () {
						KTApp.showPageLoading();
					},
					success: function (response) {
						if (response.status == true && Object.keys(response.data).length !== 0) {

							$("[name='edit_id_jenis_peralatan']").val(id_jenis_peralatan);
							$("[name='edit_nama_jenis_peralatan']").val(response.data.nama);
			
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

			const formEditJenisPeralatan = document.getElementById("form-edit-m-jenis-peralatan");
			var valid_update = FormValidation.formValidation(formEditJenisPeralatan, {
				framework: "bootstrap",
				fields: {
					edit_nama_jenis_peralatan: {
						validators: {
							notEmpty: {
								message: "Nama jenis peralatan harus diisi",
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

			const submitUpdateMJenisPeralatan = document.getElementById("btn-submit-edit-m-jenis-peralatan");
			submitUpdateMJenisPeralatan.addEventListener("click", function (e) {
				formEditJenisPeralatan.addEventListener('submit', function(event) {
					event.preventDefault();
					formEditJenisPeralatan.submit();
				});

				if (valid_update) {
					valid_update.validate().then(function (status) {
						if (status == "Valid") {
							submitUpdateMJenisPeralatan.setAttribute("data-kt-indicator", "on");
							submitUpdateMJenisPeralatan.disabled = true;

							var formData = new FormData(formEditJenisPeralatan);
							$.ajax({
								type: "POST",
								url: hostUrl + "master/peralatan/update",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitUpdateMJenisPeralatan.setAttribute("data-kt-indicator", "on");
									submitUpdateMJenisPeralatan.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_edit_peralatan").modal("hide");
										Swal.fire({
											text: "Data pengguna berhasil diperbarui",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										formEditJenisPeralatan.reset();
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
									submitUpdateMJenisPeralatan.setAttribute("data-kt-indicator", "off");
									submitUpdateMJenisPeralatan.disabled = false;
								},
								error: function (data) {
									submitUpdateMJenisPeralatan.setAttribute("data-kt-indicator", "off");
									submitUpdateMJenisPeralatan.disabled = false;

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

			$(document).on("click", ".hapus-jenis-peralatan", function (e) {
				e.preventDefault();

				var id_jenis_peralatan = $(this).attr("data-id");

				Swal.fire({
					text: "Apakah Anda yakin ingin menghapus jenis peralatan yang dipilih?",
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
							url: hostUrl + "master/peralatan/delete",
							type: "POST",
							data: { "id_jenis_peralatan[]": id_jenis_peralatan },
							beforeSend: function () {
								KTApp.showPageLoading();
							},
							success: function (data) {
								var response = JSON.parse(data);
								if (response.status == true) {
									table.ajax.reload(null, false);
									Swal.fire({
										text: "Anda telah menghapus semua jenis peralatan terpilih!",
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
