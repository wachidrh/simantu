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
				<!-- <div class="card-header border-0 pt-6">
					<div class="card-title">
						<div class="d-flex align-items-center position-relative my-1"> <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>
							<input id="search" type=" text" data-kt-m-peralatan-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari Peralatan" />
						</div>
					</div>
					<div class="card-toolbar">
						<div class="d-flex justify-content-end" data-kt-peralatan-table-toolbar="base">
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_peralatan"> Tambah </button>
						</div>
						<div class="d-flex justify-content-end align-items-center d-none" data-kt-peralatan-table-toolbar="selected">
							<div class="fw-bold me-5"> <span class="me-2" data-kt-peralatan-table-select="selected_count"></span> Terpilih
							</div>
							<button type="button" class="btn btn-danger" data-kt-peralatan-table-select="delete_selected"> Hapus Terpilih
							</button>
						</div>
					</div>
				</div> -->
				<div class="card-body pt-6">
					<div class="container">
						<h3 class="title"><?= $item_periksa[0]['nama_bangunan'] . ' - ' . $item_periksa[0]['nama'] ?></h3>
						<form method="POST" class="form w-100 mb-5" id="form-pemeriksaan-elektromekanis">
							<input type="hidden" name="id_periode" value="<?= $item_periksa[0]['id_periode'] ?>" />
							<input type="hidden" name="id_jenis_bangunan" value="<?= $item_periksa[0]['id_jenis_bangunan'] ?>" />
							<input type="hidden" name="id_jenis_peralatan" value="<?= $item_periksa[0]['id_jenis_peralatan'] ?>" />
							<?php
							foreach ($item_periksa as $key => $item) {
							?>
								<div class="row mb-2">
								<div class="col fv-row">
									<label class="required fw-semibold fs-6 mb-2">Item pemeriksaan</label>
									<input type="text" name="item" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="" value="<?= $item['nama_item']?>" readonly />
									<input type="hidden" name="id_item_peralatan[]" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="" value="<?= $item['id_item_peralatan']?>" />
									<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
								</div>
									<div class="col fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
										<label for="id_kriteria" class="required form-label">Kriteria pemeriksaan</label>
										<select name="id_kriteria[]" class="form-select form-select-sm" aria-label="Select example">
											<?php foreach ($m_kriteria as $key => $value) { ?>
												<option <?= $item['id_kriteria'] == $value['id_kriteria'] ? 'selected' : 'disabled' ?> value="<?= $value['id_kriteria'] ?>"><?= $value['kriteria'] ?></option>
											<?php } ?>
										</select>
										<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
									</div>

									<div class="col fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
										<label for="id_metode" class="required form-label">Metode pemeriksaan</label>
										<select name="id_metode[]" class="form-select form-select-sm" aria-label="Select example">
											<?php foreach ($m_metode as $key => $value) { ?>
												<option <?= $item['id_metode_pemeriksaan'] == $value['id_metode'] ? 'selected' : 'disabled' ?>  value="<?= $value['id_metode'] ?>"><?= $value['metode'] ?></option>
											<?php } ?>
										</select>
										<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
									</div>

									<div class="col fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
										<label for="hasil_periksa" class="required form-label">Hasil pemeriksaan</label>
										<select name="hasil_periksa[]" class="form-select form-select-sm" aria-label="Select example">
											<option value="">Pilih nilai hasil</option>
											<option value="BA">Baik</option>
											<option value="RR">Rusak ringan</option>
											<option value="RB">Rusak berat</option>
										</select>
										<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
									</div>
								</div>
								<div class="fv-row mb-10">
									<label class="fw-semibold fs-6 mb-2">Catatan</label>
									<input type="text" name="catatan[]" class="form-control mb-3 mb-lg-0" placeholder="" value="" />
								</div>
							<?php
							}

							?>

							<div class="d-flex flex-stack">
								<button id="btn-submit-pemeriksaan" class="btn btn-primary me-2 flex-shrink-0">
									<span class="indicator-label" data-kt-translate="btn-submit-pemeriksaan">
										Simpan
									</span>
									<span class="indicator-progress">
										<span data-kt-translate="general-progress">Harap tunggu...</span>
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
									</span>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
