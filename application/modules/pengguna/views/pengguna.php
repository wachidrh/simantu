<div class="d-flex flex-column flex-column-fluid">
	<div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
		<div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
				<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"><?php echo $pagetitle; ?></h1>
				<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
					<li class="breadcrumb-item text-muted">
						<a href="<?php echo base_url() . 'dashboard'; ?>" class="text-muted text-hover-primary">Dashboard</a>
					</li>
					<li class="breadcrumb-item">
						<span class="bullet bg-gray-500 w-5px h-2px"></span>
					</li>
					<li class="breadcrumb-item text-muted">Pengguna</li>
				</ul>
			</div>
		</div>
	</div>
	<div id="kt_app_content" class="app-content  flex-column-fluid ">
		<div id="kt_app_content_container" class="app-container  container-xxl ">
			<div class="card">
				<div class="card-header border-0 pt-6">
					<div class="card-title">
						<div class="d-flex align-items-center position-relative my-1"> <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>
							<input id="search" type=" text" data-kt-pengguna-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari Pengguna" />
						</div>
					</div>
					<div class="card-toolbar">
						<div class="d-flex justify-content-end" data-kt-pengguna-table-toolbar="base">
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_pengguna"> Tambah </button>
						</div>
						<div class="d-flex justify-content-end align-items-center d-none" data-kt-pengguna-table-toolbar="selected">
							<div class="fw-bold me-5"> <span class="me-2" data-kt-pengguna-table-select="selected_count"></span> Terpilih
							</div>
							<button type="button" class="btn btn-danger" data-kt-pengguna-table-select="delete_selected"> Hapus Terpilih
							</button>
						</div>
					</div>
				</div>
				<div class="card-body pt-0">
					<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_pengguna_table">
						<thead>
							<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
								<th class="min-w-125px">Nama</th>
								<th class="min-w-125px">Lokasi Kerja</th>
								<th class="min-w-125px">status</th>
								<th class="min-w-125px">Dibuat</th>
								<th class="text-end min-w-70px">Aksi</th>
							</tr>
						</thead>
						<tbody class="fw-semibold text-gray-600"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal tambah pengguna -->
<div class="modal fade" tabindex="-1" id="modal_add_pengguna">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Tambah Pengguna Aplikasi</h3>

				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
					<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
				</div>
				<!--end::Close-->
			</div>

			<div class="modal-body">
				<form method="POST" class="form w-100" id="form-tambah-pengguna">
					<div class="fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="kopeg" class="required form-label">Kode pegawai</label>
						<input type="text" class="form-control form-control-solid" name="kopeg" placeholder="Masukkan kopeg" />
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>
					<div class="fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="nama" class="required form-label">Nama pegawai</label>
						<input type="text" class="form-control form-control-solid" name="nama" placeholder="Masukkan nama" />
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>
					<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="level" class="required form-label">Level pengguna</label>
						<select name="level" class="form-select" aria-label="Select example">
							<option value="">Pilih level</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>
					<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="lokasi" class="required form-label">Lokasi kerja</label>
						<select name="lokasi" class="form-select" aria-label="Select example">
							<option value="">Pilih lokasi kerja</option>
							<?php
							foreach ($m_lokasi as $lokasi) {
								echo '<option value="' . $lokasi['id_lokasi'] . '">' . $lokasi['nama_lokasi'] . '</option>';
							}
							?>

						</select>
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>

					<div class="col fv-row form-check-custom form-check-solid mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<input class="form-check-input" type="checkbox" name="is_admin" id="form_checkbox" />
						<label class="form-check-label" for="form_checkbox">
							Admin
						</label>
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
				<div class="d-flex flex-stack">
					<button id="btn-submit-tambah-pengguna" class="btn btn-primary me-2 flex-shrink-0">
						<span class="indicator-label" data-kt-translate="btn-submit-tambah-pengguna">
							Simpan
						</span>
						<span class="indicator-progress">
							<span data-kt-translate="general-progress">Harap tunggu...</span>
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal edit pengguna -->
<div class="modal fade" tabindex="-1" id="modal_edit_pengguna">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Edit Pengguna Aplikasi</h3>

				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
					<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
				</div>
				<!--end::Close-->
			</div>

			<div class="modal-body">
				<form method="POST" class="form w-100" id="form-edit-pengguna">
					<input type="text" hidden name="edit_id_pengguna">
					<div class="fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="kopeg" class="required form-label">Kode pegawai</label>
						<input readonly type="text" class="form-control form-control-solid" name="edit_kopeg" placeholder="Masukkan kopeg" />
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>
					<div class="fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="nama" class="required form-label">Nama pegawai</label>
						<input readonly type="text" class="form-control form-control-solid" name="edit_nama" placeholder="Masukkan nama" />
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>
					<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="lokasi" class="required form-label">Lokasi kerja</label>
						<select name="edit_lokasi" class="form-select" aria-label="Select example">
							<option value="">Pilih lokasi kerja</option>
							<?php
							foreach ($m_lokasi as $lokasi) {
								echo '<option value="' . $lokasi['id_lokasi'] . '">' . $lokasi['nama_lokasi'] . '</option>';
							}
							?>

						</select>
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>

					<div class="col fv-row form-check-custom form-check-solid mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="lokasi" class="required form-label">Status pengguna</label>
						<input class="form-check-input" type="checkbox" name="edit_is_aktif" id="edit_is_aktif" />
						<label class="form-check-label" for="form_checkbox">
							Aktif
						</label>
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
				<div class="d-flex flex-stack">
					<button id="btn-submit-update-pengguna" class="btn btn-primary me-2 flex-shrink-0">
						<span class="indicator-label" data-kt-translate="btn-submit-update-pengguna">
							Simpan
						</span>
						<span class="indicator-progress">
							<span data-kt-translate="general-progress">Harap tunggu...</span>
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>