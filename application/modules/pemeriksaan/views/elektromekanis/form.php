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
					<form method="POST" class="form w-100 mb-5" id="form-pemeriksaan-elektromekanis">
						<input type="hidden" name="id_periode" value="<?= $bangunan['item_pemeriksaan'][0]['id_periode'] ?>">
						<?php
						$last_id_bangunan = 0;
						$last_id_peralatan = 0;
						$last_id_item = 0;
						$last_start_bangunan = 1;
						$last_start_peralatan = 1;

						foreach ($bangunan['item_pemeriksaan'] as $key => $item) {
							if ($last_id_peralatan != $item['id_jenis_peralatan']) {
						?>
								<h3>
									<ol type="A" start="<?= $last_start_peralatan ?>">
										<li>
											<?= $item['nama'] ?>
										</li>
									</ol>
								</h3>


							<?php
							}
							if ($key == 0) {
							?>
								<!--begin::Form group-->

								<div id="kt_repeater_bangunan">
									<div class="form-group">
										<div data-repeater-list="repeater_bangunan">
										<?php } ?>
										<div data-repeater-item class="mb-3">
											<input type="hidden" name="id_jenis_bangunan" value="<?= $item['id_jenis_bangunan'] ?>">
											<input type="hidden" name="id_jenis_peralatan" value="<?= $item['id_jenis_peralatan'] ?>">
											<input type="hidden" name="id_item_peralatan" value="<?= $item['id_item_peralatan'] ?>">
											<div class="form-group row mb-5 pb-2">
												<div class="col-lg-4">
													<label class="form-label">Nama Peralatan:</label>
													<input type="text" class="form-control form-control-sm mb-2 mb-md-0" readonly value="<?= $item['nama_item'] ?>" />
												</div>
												<div class="col">
													<div class="item-repeater">
														<div data-repeater-list="repeater_kriteria" class="">
															<div data-repeater-item class="row">
																<div class="col-lg-4 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																	<label for="id_kriteria" class="required form-label">Kriteria pemeriksaan</label>
																	<select name="id_kriteria" class="form-select form-select-sm" aria-label="Select example">
																		<option value="">Pilih kriteria</option>
																		<?php foreach ($m_kriteria as $key => $value) { ?>
																			<option value="<?= $value['id_kriteria'] ?>"><?= $value['kriteria'] ?></option>
																		<?php } ?>
																	</select>
																	<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																</div>

																<div class="col-lg-4 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																	<label for="id_metode" class="required form-label">Metode pemeriksaan</label>
																	<select name="id_metode" class="form-select form-select-sm" aria-label="Select example">
																		<option value="">Pilih metode</option>
																		<?php foreach ($m_metode as $key => $value) { ?>
																			<option value="<?= $value['id_metode'] ?>"><?= $value['metode'] ?></option>
																		<?php } ?>
																	</select>
																	<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																</div>

																<div class="col-lg-4 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																	<label for="hasil_periksa" class="required form-label">Hasil pemeriksaan</label>
																	<select name="hasil_periksa" class="form-select form-select-sm" aria-label="Select example">
																		<option value="">Pilih nilai hasil</option>
																		<option value="BA">Baik</option>
																		<option value="RR">Rusak ringan</option>
																		<option value="RB">Rusak berat</option>
																	</select>
																	<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																</div>

																<div class="col">
																	<button class="border border-secondary btn btn-sm btn-icon btn-flex btn-light-danger mb-2" data-repeater-delete type="button">
																		<i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
																	</button>
																</div>

															</div>
														</div>

														<button class=" btn btn-sm btn-flex btn-light-primary" data-repeater-create type="button">
															<i class="ki-duotone ki-plus fs-5"></i>
															Add Number
														</button>
													</div>
												</div>
											</div>
										</div>
										<?php if ($key == sizeof($bangunan['item_pemeriksaan']) - 1) { ?>

										</div>
									</div>
								</div>
								<!--end::Form group-->
						<?php
										}
										$last_id_bangunan = $item['id_jenis_bangunan'];
										if ($last_id_peralatan != $item['id_jenis_peralatan']) {
											$last_start_peralatan++;
										}
										$last_id_peralatan = $item['id_jenis_peralatan'];
										$last_id_item = $item['id_item_peralatan'];
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