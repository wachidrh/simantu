"use strict";

var KTPenggunaList = (function () {
	var t, e, o, n, table;

	return {
		init: function () {
			var url = hostUrl + "pengguna/get-pengguna";
			table = $("#kt_pengguna_table").DataTable({
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
					emptyTable: "Data pengguna belum tersedia",
					zeroRecords: "Data pengguna tidak ditemukan",
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
						orderable: false,
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
					}
				],

				dom: '<"top"l>rt<"bottom left"pi><"caption right"><"clear">',
			});

			$("#search").keyup(function (event) {
				table.ajax.reload(null, false);
			});

			// Add Asal Pengguna
			const formPengguna = document.getElementById("form-tambah-pengguna");
			var valid_pengguna = FormValidation.formValidation(formPengguna, {
				framework: "bootstrap",
				fields: {
					kopeg: {
						validators: {
							notEmpty: {
								message: "Kode pegawai harus diisi",
							},
						},
					},
					nama: {
						validators: {
							notEmpty: {
								message: "Nama harus diisi",
							},
						},
					},
                    level: {
						validators: {
							notEmpty: {
								message: "Pilih salah satu",
							},
						},
					},
					lokasi: {
						validators: {
							notEmpty: {
								message: "Pilih salah satu",
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

			const submitPengguna = document.getElementById("btn-submit-tambah-pengguna");
			submitPengguna.addEventListener("click", function (e) {
				e.preventDefault();

				if (valid_pengguna) {
					valid_pengguna.validate().then(function (status) {
						if (status == "Valid") {
							submitPengguna.setAttribute("data-kt-indicator", "on");
							submitPengguna.disabled = true;

							var formData = new FormData(formPengguna);
							$.ajax({
								type: "POST",
								url: hostUrl + "pengguna/pengguna/store",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitPengguna.setAttribute("data-kt-indicator", "on");
									submitPengguna.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_add_pengguna").modal("hide");
										Swal.fire({
											text: "Data Pengguna berhasil ditambahkan",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										document.getElementById("form-add-pengguna").reset();
									} else {
										toastr.warning(result.messages, "Gagal!", {
											timeOut: 2000,
											extendedTimeOut: 0,
											closeButton: true,
											closeDuration: 0,
										});
									}
								},
								complete: function (data) {
									submitPengguna.setAttribute("data-kt-indicator", "off");
									submitPengguna.disabled = false;
								},
								error: function (data) {
									submitPengguna.setAttribute("data-kt-indicator", "off");
									submitPengguna.disabled = false;

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
			// Add Asal Pengguna

			// Edit Asal Pengguna
			$(document).on("click", ".ubah-pengguna", function (e) {
				e.preventDefault();
				var id_pengguna = $(this).attr("data-id");
				
				$.ajax({
					url: hostUrl + "pengguna/pengguna/lookup",
					type: "POST",
					data: { id_pengguna: id_pengguna },
					dataType: "json",
					beforeSend: function () {
						KTApp.showPageLoading();
					},
					success: function (response) {
						if (response.status == true && Object.keys(response.data).length !== 0) {

							$("[name='edit_id_pengguna']").val(response.data.auth_id);
							$("[name='edit_lokasi']").val(response.data.unit_id).trigger("change");
							$("[name='edit_kopeg']").val(response.data.kopeg);
							$("[name='edit_nama']").val(response.data.full_name);

							
							let is_aktif = response.data.is_aktif == 1 ? true : false;
							$("#edit_is_aktif").prop("checked", is_aktif);
			
							$("#modal_edit_pengguna").modal("show");
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

			// Edit Asal Pengguna
			const formEditPengguna = document.getElementById("form-edit-pengguna");
			var valid_update = FormValidation.formValidation(formEditPengguna, {
				framework: "bootstrap",
				fields: {
					edit_lokasi: {
						validators: {
							notEmpty: {
								message: "Pilih salah satu",
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

			const updatePengguna = document.getElementById("btn-submit-update-pengguna");
			updatePengguna.addEventListener("click", function (e) {
				formEditPengguna.addEventListener('submit', function(event) {
					event.preventDefault();
					formEditPengguna.submit();
				});

				if (valid_update) {
					valid_update.validate().then(function (status) {
						if (status == "Valid") {
							updatePengguna.setAttribute("data-kt-indicator", "on");
							updatePengguna.disabled = true;

							var formData = new FormData(formEditPengguna);
							$.ajax({
								type: "POST",
								url: hostUrl + "pengguna/pengguna/update",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									updatePengguna.setAttribute("data-kt-indicator", "on");
									updatePengguna.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_edit_pengguna").modal("hide");
										Swal.fire({
											text: "Data pengguna berhasil diperbarui",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										document.getElementById("form-edit-pengguna").reset();
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
									updatePengguna.setAttribute("data-kt-indicator", "off");
									updatePengguna.disabled = false;
								},
								error: function (data) {
									updatePengguna.setAttribute("data-kt-indicator", "off");
									updatePengguna.disabled = false;

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

			$(document).on("click", ".hapus-pengguna", function (e) {
				e.preventDefault();

				var id_pengguna = $(this).attr("data-id");

				Swal.fire({
					text: "Apakah Anda yakin ingin menghapus pengguna yang dipilih?",
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
							url: hostUrl + "pengaturan/pengguna/hapus-pengguna",
							type: "POST",
							data: { "id_pengguna[]": id_pengguna },
							beforeSend: function () {
								KTApp.showPageLoading();
							},
							success: function (data) {
								var response = JSON.parse(data);
								if (response.status == true) {
									table.ajax.reload(null, false);
									Swal.fire({
										text: "Anda telah menghapus semua pengguna terpilih!",
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

			(n = $("#kt_pengguna_table")) &&
				((t = table).on("draw", function () {
				}));
		},
	};
})();

$(document).ready(function () {
	KTPenggunaList.init();
});
