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
					}
				],

				dom: '<"top"l>rt<"bottom left"pi><"caption right"><"clear">',
			});

			$("#search").keyup(function (event) {
				table.ajax.reload(null, false);
			});

			// Add Asal Pengguna
			const formPengguna = document.getElementById("frm-add-pengguna");
			var valid_pengguna = FormValidation.formValidation(formPengguna, {
				framework: "bootstrap",
				fields: {
					peran_id: {
						validators: {
							notEmpty: {
								message: "Pilih salah satu",
							},
						},
					},
					nama_pengguna: {
						validators: {
							notEmpty: {
								message: "Nama Lengkap harus diisi",
							},
						},
					},
					kopeg: {
						validators: {
							notEmpty: {
								message: "Nama Pengguna harus diisi",
							},
						},
					},
                    password: {
						validators: {
							notEmpty: {
								message: "Kata Sandi harus diisi",
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

            $("#kopeg").on("change", function () {
				const kopeg = $(this).val();
                const field = formPengguna.querySelector('[name="kopeg"]');
				const errorMessage = "Nama Pengguna sudah digunakan";
                
                $.ajax({
                    url: hostUrl + "pengaturan/pengguna/check-pengguna",
                    type: "POST",
                    data: { kopeg: kopeg },
                    success: function (data) {
                        var result = JSON.parse(data);
                        if (result.status == true) {
                            field.classList.add("is-invalid");
                            let errorElement =
                                field.parentNode.querySelector(".invalid-feedback");

                            if (!errorElement) {
                                errorElement = document.createElement("div");
                                errorElement.classList.add("invalid-feedback");
                                field.parentNode.appendChild(errorElement);
                            }
                            errorElement.innerText = errorMessage;
                            $("#kopeg").val("");
                        } else {
                            field.classList.remove("is-invalid");
                            const errorElement =
                                field.parentNode.querySelector(".invalid-feedback");
                            if (errorElement) {
                                errorElement.remove();
                            }
                        }
                    },
                });
            });
             
            
			const submitPengguna = document.getElementById("btn-submit-pengguna");
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
								url: hostUrl + "pengaturan/pengguna/add-pengguna",
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

										document.getElementById("frm-add-pengguna").reset();
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
			const formEditPengguna = document.getElementById("frm-edit-pengguna");
			var valid_update = FormValidation.formValidation(formEditPengguna, {
				framework: "bootstrap",
				fields: {
					_peran_id: {
						validators: {
							notEmpty: {
								message: "Pilih salah satu",
							},
						},
					},
					_nama_pengguna: {
						validators: {
							notEmpty: {
								message: "Nama Lengkap harus diisi",
							},
						},
					},
					_kopeg: {
						validators: {
							notEmpty: {
								message: "Nama Pengguna harus diisi",
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

			const updatePengguna = document.getElementById("btn-update-pengguna");
			updatePengguna.addEventListener("click", function (e) {
				e.preventDefault();

				if (valid_update) {
					valid_update.validate().then(function (status) {
						if (status == "Valid") {
							updatePengguna.setAttribute("data-kt-indicator", "on");
							updatePengguna.disabled = true;

							var formData = new FormData(formEditPengguna);
							$.ajax({
								type: "POST",
								url: hostUrl + "pengaturan/pengguna/update-pengguna",
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

										document.getElementById("frm-edit-pengguna").reset();
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
					r();
					l();
				}),
				r());
		},
	};
})();

$(document).ready(function () {
	KTPenggunaList.init();
});

$(document).on("click", ".ubah-pengguna", function (e) {
	e.preventDefault();
	var pengguna_id = $(this).attr("data-id");
    
	$.ajax({
		url: hostUrl + "pengaturan/pengguna/detail-pengguna",
		type: "POST",
		data: { pengguna_id: pengguna_id },
		dataType: "json",
		beforeSend: function () {
			KTApp.showPageLoading();
		},
		success: function (response) {
			if (response.status == true) {
                $("#_pengguna_id").val(pengguna_id);
                
				$("#_peran_id").val(response.messages.level_id).trigger("change");
				$("#_nama_pengguna").val(response.messages.full_name);
				$("#_email_pengguna").val(response.messages.email);
				$("#_telepon_pengguna").val(response.messages.mobile_phone);
                $("#_divisi_id").val(response.messages.unit_id).trigger("change");
                $("#_jabatan").val(response.messages.jabatan);
                $("#_kopeg").val(response.messages.kopeg);

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
