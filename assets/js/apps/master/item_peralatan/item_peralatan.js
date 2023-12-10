"use strict";

var KTMPeralatanList = (function () {
	var t, e, o, n, table;

	return {
		init: function () {
			var url = hostUrl + "master/item-peralatan/list";
			table = $("#kt_m_item_peralatan_table").DataTable({
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
			const formTambahMItemPeralatan = document.getElementById("form-tambah-m-item-peralatan");
			var valid_form_tambah = FormValidation.formValidation(formTambahMItemPeralatan, {
				framework: "bootstrap",
				fields: {
					nama_item_peralatan: {
						validators: {
							notEmpty: {
								message: "Nama item peralatan harus diisi",
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

			const submitSimpanMItemPeralatan = document.getElementById("btn-submit-tambah-m-item-peralatan");
			submitSimpanMItemPeralatan.addEventListener("click", function (e) {
				formTambahMItemPeralatan.addEventListener('submit', function(event) {
					event.preventDefault();
					formTambahMItemPeralatan.submit();
				});
				
				if (valid_form_tambah) {
					valid_form_tambah.validate().then(function (status) {
						if (status == "Valid") {
							submitSimpanMItemPeralatan.setAttribute("data-kt-indicator", "on");
							submitSimpanMItemPeralatan.disabled = true;

							var formData = new FormData(formTambahMItemPeralatan);
							console.log(formData);
							$.ajax({
								type: "POST",
								url: hostUrl + "master/item-peralatan/store",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitSimpanMItemPeralatan.setAttribute("data-kt-indicator", "on");
									submitSimpanMItemPeralatan.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_add_item_peralatan").modal("hide");
										Swal.fire({
											text: "Data item peralatan berhasil ditambahkan",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										formTambahMItemPeralatan.reset();
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
									submitSimpanMItemPeralatan.setAttribute("data-kt-indicator", "off");
									submitSimpanMItemPeralatan.disabled = false;
								},
								error: function (data) {
									submitSimpanMItemPeralatan.setAttribute("data-kt-indicator", "off");
									submitSimpanMItemPeralatan.disabled = false;

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
			$(document).on("click", ".ubah-item-peralatan", function (e) {
				e.preventDefault();
				var id_item_peralatan = $(this).attr("data-id");
				
				$.ajax({
					url: hostUrl + "master/item-peralatan/lookup",
					type: "POST",
					data: { id_item_peralatan: id_item_peralatan },
					dataType: "json",
					beforeSend: function () {
						KTApp.showPageLoading();
					},
					success: function (response) {
						if (response.status == true && Object.keys(response.data).length !== 0) {

							$("[name='edit_id_item_peralatan']").val(id_item_peralatan);
							$("[name='edit_nama_item_peralatan']").val(response.data.nama_item);
			
							$("#modal_edit_item_peralatan").modal("show");
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

			const formEditItemPeralatan = document.getElementById("form-edit-m-item-peralatan");
			var valid_update = FormValidation.formValidation(formEditItemPeralatan, {
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

			const submitUpdateMItemPeralatan = document.getElementById("btn-submit-edit-m-item-peralatan");
			submitUpdateMItemPeralatan.addEventListener("click", function (e) {
				formEditItemPeralatan.addEventListener('submit', function(event) {
					event.preventDefault();
					formEditItemPeralatan.submit();
				});

				if (valid_update) {
					valid_update.validate().then(function (status) {
						if (status == "Valid") {
							submitUpdateMItemPeralatan.setAttribute("data-kt-indicator", "on");
							submitUpdateMItemPeralatan.disabled = true;

							var formData = new FormData(formEditItemPeralatan);
							$.ajax({
								type: "POST",
								url: hostUrl + "master/item-peralatan/update",
								data: formData,
								contentType: false,
								cache: false,
								processData: false,
								beforeSend: function (data) {
									submitUpdateMItemPeralatan.setAttribute("data-kt-indicator", "on");
									submitUpdateMItemPeralatan.disabled = true;
								},
								success: function (data) {
									const result = JSON.parse(data);
									if (result.status == true) {
										$("#modal_edit_item_peralatan").modal("hide");
										Swal.fire({
											text: "Data pengguna berhasil diperbarui",
											icon: "success",
											confirmButtonColor: "#3085d6",
											confirmButtonText: "Ok",
										});
										table.ajax.reload(null, false);

										formEditItemPeralatan.reset();
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
									submitUpdateMItemPeralatan.setAttribute("data-kt-indicator", "off");
									submitUpdateMItemPeralatan.disabled = false;
								},
								error: function (data) {
									submitUpdateMItemPeralatan.setAttribute("data-kt-indicator", "off");
									submitUpdateMItemPeralatan.disabled = false;

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

			$(document).on("click", ".hapus-item-peralatan", function (e) {
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
