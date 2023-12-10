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
                    <li class="breadcrumb-item text-muted"><?= $pagetitle ?></li>
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
                            <input id="search" type=" text" data-kt-m-kriteria-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari Kriteria" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-kriteria-table-toolbar="base">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_kriteria"> Tambah </button>
                        </div>
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-kriteria-table-toolbar="selected">
                            <div class="fw-bold me-5"> <span class="me-2" data-kt-kriteria-table-select="selected_count"></span> Terpilih
                            </div>
                            <button type="button" class="btn btn-danger" data-kt-kriteria-table-select="delete_selected"> Hapus Terpilih
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_m_kriteria_table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Kriteria</th>
                                <th class="min-w-125px">Diperbarui</th>
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

<!-- modal tambah m kriteria pemeriksaan -->
<div class="modal fade" tabindex="-1" id="modal_add_kriteria">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah kriteria pemeriksaan (Master)</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form method="POST" class="form w-100" id="form-tambah-m-kriteria">
					<div class="fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="kriteria" class="required form-label">Kriteria Pemeriksaan</label>
						<input type="text" class="form-control form-control-solid" name="kriteria" placeholder="Masukkan kriteria pemeriksaan"/>
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>
				</form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <div class="d-flex flex-stack">
					<button id="btn-submit-tambah-m-kriteria" class="btn btn-primary me-2 flex-shrink-0">
						<span class="indicator-label" data-kt-translate="btn-submit-tambah-m-kriteria">
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

<!-- modal edit m kriteria pemeriksaan -->
<div class="modal fade" tabindex="-1" id="modal_edit_kriteria">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit kriteria pemeriksaan (Master)</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form method="POST" class="form w-100" id="form-edit-m-kriteria">
					<input type="text" hidden name="edit_id_kriteria">
					<div class="fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="edit_kriteria" class="required form-label">Kriteria pemeriksaan</label>
						<input type="text" class="form-control form-control-solid" name="edit_kriteria" placeholder="Masukkan kriteria pemeriksaan"/>
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>
				</form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <div class="d-flex flex-stack">
					<button id="btn-submit-edit-m-kriteria" class="btn btn-primary me-2 flex-shrink-0">
						<span class="indicator-label" data-kt-translate="btn-submit-edit-m-kriteria">
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
