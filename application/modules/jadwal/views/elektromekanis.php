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
							<input id="search" type=" text" data-kt-m-bangunan-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari metode" />
						</div>
					</div>
					<div class="card-toolbar">
						<div class="d-flex justify-content-end" data-kt-bangunan-table-toolbar="base">
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_generate_jadwal"> Buat baru </button>
						</div>
						<div class="d-flex justify-content-end align-items-center d-none" data-kt-metode-table-toolbar="selected">
							<div class="fw-bold me-5"> <span class="me-2" data-kt-bangunan-table-select="selected_count"></span> Terpilih
							</div>
							<button type="button" class="btn btn-danger" data-kt-bangunan-table-select="delete_selected"> Hapus Terpilih
							</button>
						</div>
					</div>
				</div>
				<div class="card-body pt-0">
					<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_jadwal">
						<thead>
							<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
								<th class="min-w-125px">Tanggal dibuat</th>
								<th class="min-w-125px">Triwulan</th>
								<th class="min-w-125px">Tahun pemeriksaan</th>
								<th class="min-w-125px">Dibuat oleh</th>
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

<!-- modal generate jadwal -->
<div class="modal fade" tabindex="-1" id="modal_generate_jadwal">
	<div class="modal-dialog modal-fullscreen">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Buat Jadwal Baru</h3>

				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
					<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
				</div>
				<!--end::Close-->
			</div>

			<div class="modal-body">
				<!--begin::Stepper-->
				<div class="stepper stepper-pills" id="stepper_jadwal">
					<!--begin::Nav-->
					<div class="stepper-nav flex-center flex-wrap mb-10">
						<!--begin::Step 1-->
						<div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
							<!--begin::Wrapper-->
							<div class="stepper-wrapper d-flex align-items-center">
								<!--begin::Icon-->
								<div class="stepper-icon w-40px h-40px">
									<i class="stepper-check fas fa-check"></i>
									<span class="stepper-number">1</span>
								</div>
								<!--end::Icon-->

								<!--begin::Label-->
								<div class="stepper-label">
									<h3 class="stepper-title">
										Pemeriksaan
									</h3>
								</div>
								<!--end::Label-->
							</div>
							<!--end::Wrapper-->

							<!--begin::Line-->
							<div class="stepper-line h-40px"></div>
							<!--end::Line-->
						</div>
						<!--end::Step 1-->

						<!--begin::Step 2-->
						<div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
							<!--begin::Wrapper-->
							<div class="stepper-wrapper d-flex align-items-center">
								<!--begin::Icon-->
								<div class="stepper-icon w-40px h-40px">
									<i class="stepper-check fas fa-check"></i>
									<span class="stepper-number">2</span>
								</div>
								<!--begin::Icon-->

								<!--begin::Label-->
								<div class="stepper-label">
									<h3 class="stepper-title">
										Perawatan
									</h3>
								</div>
								<!--end::Label-->
							</div>
							<!--end::Wrapper-->

							<!--begin::Line-->
							<div class="stepper-line h-40px"></div>
							<!--end::Line-->
						</div>
						<!--end::Step 2-->
					</div>
					<!--end::Nav-->

					<!--begin::Group-->
					<div class="mb-5">
						<!--begin::Step 1-->
						<div class="flex-column current" data-kt-stepper-element="content">
							<form method="POST" class="form w-100" id="form-tambah-jadwal-elektromekanis">
								<div class="row">

									<div class="col-4 fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
										<label for="nama_bangunan" class="required form-label">Lokasi jadwal pemeriksaan</label>
										<div class="input-group">
											<input type="text" class="form-control" value="<?= $lokasi['nama_lokasi'] ?>" readonly />
										</div>
										<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
									</div>
									<div class="col-4 fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
										<label for="nama_bangunan" class="required form-label">Tahun Periode</label>
										<div class="input-group" id="dt_picker_tahun" data-td-target-input="nearest" data-td-target-toggle="nearest">
											<input id="dt_picker_tahun_input" name="tahun_jadwal" type="text" value="<?= date('Y') ?>" class="form-control" data-td-target="#dt_picker_tahun" />
											<span class="input-group-text" data-td-target="#dt_picker_tahun" data-td-toggle="datetimepicker">
												<i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
											</span>
										</div>
										<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
									</div>

									<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
										<label for="triwulan" class="required form-label">Triwulan ke -</label>
										<select name="triwulan" class="form-select" aria-label="Select example">
											<option>Pilih triwulan</option>
											<option value="1">Triwulan 1</option>
											<option value="2">Triwulan 2</option>
											<option value="3">Triwulan 3</option>
											<option value="4">Triwulan 4</option>
										</select>
										<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
									</div>
								</div>

								<div id="repeater_bangunan">
									<div class="form-group">
										<div data-repeater-list="repeater_bangunan_outer">
											<div data-repeater-item>
												<div class="row bg-light py-4 mb-2">
													<div class="col-2 fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
														<label for="jenis_bangunan" class="required form-label">Jenis Bangunan</label>
														<select name="id_jenis_bangunan" class="form-select" aria-label="Select example">
															<option value="">Pilih jenis bangunan</option>
															<?php
															foreach ($bangunan as $b) {
																echo '<option value="' . $b->id_jenis_bangunan . '">' . $b->nama_bangunan . '</option>';
															}
															?>
														</select>
														<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
													</div>
													<div class="repeater-peralatan col">
														<div data-repeater-list="repeater_peralatan">
															<div data-repeater-item>
																<div class="row">
																	<div class="col-2 fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																		<label for="jenis_bangunan" class="required form-label">Jenis Peralatan</label>
																		<select name="id_jenis_peralatan" class="form-select" aria-label="Select example">
																			<option value="">Pilih peralatan</option>
																			<?php
																			foreach ($peralatan as $alat) {
																				echo '<option value="' . $alat->id_jenis_peralatan . '">' . $alat->nama . '</option>';
																			}
																			?>
																		</select>
																		<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																	</div>
																	<div class="repeater-item col">
																		<div data-repeater-list="repeater_item">
																			<div data-repeater-item>
																				<div class="row mb-0">
																					<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																						<label for="jenis_bangunan" class="required form-label">Jenis item Peralatan</label>
																						<select name="id_item_peralatan" class="form-select" aria-label="Select example">
																							<option value="">Pilih item peralatan</option>
																							<?php
																							foreach ($item_peralatan as $item) {
																								echo '<option value="' . $item->id_item_peralatan . '">' . $item->nama_item . '</option>';
																							}
																							?>
																						</select>
																						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																					</div>
																					<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																						<label for="jenis_bangunan" class="required form-label">Kriteria</label>
																						<select name="id_kriteria" class="form-select" aria-label="Select example">
																							<option value="">Pilih kriteria pemeriksaan</option>
																							<?php
																							foreach ($kriteria as $k) {
																								echo '<option value="' . $k->id_kriteria . '">' . $k->kriteria . '</option>';
																							}
																							?>
																						</select>
																						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																					</div>
																					<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																						<label for="jenis_bangunan" class="required form-label">Metode pemeriksaan</label>
																						<select name="id_metode" class="form-select" aria-label="Select example">
																							<option value="">Pilih metode pemeriksaan</option>
																							<?php
																							foreach ($metode as $m) {
																								echo '<option value="' . $m->id_metode . '">' . $m->metode . '</option>';
																							}
																							?>
																						</select>
																						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																					</div>
																					<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																						<label for="jenis_bangunan" class="required form-label">Periode</label>
																						<select name="id_periode" class="form-select" aria-label="Select example">
																							<option value="">Pilih periode pemeriksaan</option>
																							<?php
																							foreach ($periode as $p) {
																								echo '<option value="' . $p->id_periode . '">' . $p->periode . '</option>';
																							}
																							?>
																						</select>
																						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																					</div>
																					<div class="col">
																						<label class="form-label">Hari / Tanggal Periksa:</label>
																						<input name="tgl_periksa" class="form-control tgl_periksa" data-kt-repeater="tgl_periksa" placeholder="Pilih hari / tanggal" />
																					</div>
																					<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																						<label for="keterangan" class="form-label">Keterangan</label>
																						<div class="input-group">
																							<input type="text" class="form-control" name="keterangan" placeholder="Keterangan" />
																						</div>
																						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																					</div>
																				</div>
																				<button class="btn btn-sm btn-light-danger mb-2" data-repeater-delete type="button">
																					<i class="ki-duotone ki-trash fs-5"></i>
																					Hapus item
																				</button>
																			</div>
																		</div>
																		<button class="btn btn-sm btn-flex btn-light-primary" data-repeater-create type="button">
																			<i class="ki-duotone ki-plus fs-5"></i>
																			Tambah Item
																		</button>
																	</div>
																</div>
																<button class="btn btn-sm btn-light-danger mb-2" data-repeater-delete type="button">
																	<i class="ki-duotone ki-trash fs-5"></i>
																	Hapus Alat
																</button>
															</div>
														</div>
														<button class="btn btn-sm btn-flex btn-light-primary" data-repeater-create type="button">
															<i class="ki-duotone ki-plus fs-5"></i>
															Tambah Alat
														</button>
													</div>
												</div>
												<button class="btn btn-sm btn-flex btn-light-danger mb-2" data-repeater-delete type="button">
													<i class="ki-duotone ki-trash fs-5"></i>
													Hapus Bangunan
												</button>
											</div>
										</div>
									</div>
									<div class="form-group">
										<a href="javascript:;" data-repeater-create class="btn btn-flex btn-light-primary">
											<i class="ki-duotone ki-plus fs-3"></i>
											Tambah Bangunan
										</a>
									</div>
								</div>
						</div>
						<!--begin::Step 1-->

						<!--begin::Step 1-->
						<div class="flex-column" data-kt-stepper-element="content">
							<div id="repeater_rawat_bangunan">
								<div class="form-group">
									<div data-repeater-list="repeater_rawat_bangunan_outer">
										<div data-repeater-item>
											<div class="row bg-secondary py-2 mb-2">
												<div class="col-2 fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
													<label for="rawat_id_jenis_bangunan" class="required form-label">Jenis Bangunan</label>
													<select name="id_jenis_bangunan" class="form-select" aria-label="Select example">
														<option value="">Pilih jenis bangunan</option>
														<?php
														foreach ($bangunan as $b) {
															echo '<option value="' . $b->id_jenis_bangunan . '">' . $b->nama_bangunan . '</option>';
														}
														?>
													</select>
													<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
												</div>
												<div class="repeater-rawat-peralatan col">
													<div data-repeater-list="repeater_rawat_peralatan">
														<div data-repeater-item>
															<div class="row">
																<div class="col-2 fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																	<label for="rawat_id_jenis_peralatan" class="required form-label">Jenis Peralatan</label>
																	<select name="id_jenis_peralatan" class="form-select" aria-label="Select example">
																		<option value="">Pilih peralatan</option>
																		<?php
																		foreach ($peralatan as $alat) {
																			echo '<option value="' . $alat->id_jenis_peralatan . '">' . $alat->nama . '</option>';
																		}
																		?>
																	</select>
																	<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																</div>
																<div class="repeater-rawat-item col">
																	<div data-repeater-list="repeater_rawat_item">
																		<div data-repeater-item>
																			<div class="row">
																				<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																					<label for="jenis_bangunan" class="required form-label">Jenis item Peralatan</label>
																					<select name="id_item_peralatan" class="form-select" aria-label="Select example">
																						<option value="">Pilih item peralatan</option>
																						<?php
																						foreach ($item_peralatan as $item) {
																							echo '<option value="' . $item->id_item_peralatan . '">' . $item->nama_item . '</option>';
																						}
																						?>
																					</select>
																					<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																				</div>
																				<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																					<label for="jenis_bangunan" class="required form-label">Pilihan pelaksanaan</label>
																					<select name="id_pelaksanaan" class="form-select" aria-label="Select example">
																						<option value="">Pilih metode pelaksanaan</option>
																						<option value="B">Pembersihan</option>
																						<option value="S">Setel</option>
																						<option value="Gr">Grease</option>
																						<option value="P">Pelumasan</option>
																						<option value="U">Uji coba</option>
																						<option value="G">Penggantian</option>
																						<option value="C">Pengecatan</option>
																					</select>
																					<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																				</div>
																				<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																					<label for="jenis_bangunan" class="required form-label">Periode</label>
																					<select name="id_periode" class="form-select" aria-label="Select example">
																						<option value="">Pilih periode pemeriksaan</option>
																						<?php
																						foreach ($periode as $p) {
																							echo '<option value="' . $p->id_periode . '">' . $p->periode . '</option>';
																						}
																						?>
																					</select>
																					<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																				</div>
																				<div class="col fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
																					<label for="keterangan" class="form-label">Keterangan</label>
																					<div class="input-group">
																						<input type="text" class="form-control" name="keterangan" placeholder="Keterangan" />
																					</div>
																					<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
																				</div>
																				<div class="col">
																					<label class="form-label">Hari / Tanggal Periksa:</label>
																					<input name="tgl_periksa" class="form-control tgl_periksa" data-kt-repeater="tgl_periksa" placeholder="Pilih hari / tanggal" />
																				</div>
																			</div>
																			<button class="btn btn-sm btn-light-danger mb-2" data-repeater-delete type="button">
																				<i class="ki-duotone ki-trash fs-5"></i>
																				Hapus item
																			</button>
																		</div>
																	</div>
																	<button class="btn btn-sm btn-flex btn-light-primary" data-repeater-create type="button">
																		<i class="ki-duotone ki-plus fs-5"></i>
																		Tambah Item
																	</button>
																</div>
															</div>
															<button class="btn btn-sm btn-light-danger mb-2" data-repeater-delete type="button">
																<i class="ki-duotone ki-trash fs-5"></i>
																Hapus Alat
															</button>
														</div>
													</div>
													<button class="btn btn-sm btn-flex btn-light-primary" data-repeater-create type="button">
														<i class="ki-duotone ki-plus fs-5"></i>
														Tambah Alat
													</button>
												</div>
											</div>
											<button class="btn btn-sm btn-flex btn-light-danger mb-2" data-repeater-delete type="button">
												<i class="ki-duotone ki-trash fs-5"></i>
												Hapus Bangunan
											</button>
										</div>
									</div>
								</div>
								<div class="form-group">
									<a href="javascript:;" data-repeater-create class="btn btn-flex btn-light-primary">
										<i class="ki-duotone ki-plus fs-3"></i>
										Tambah Bangunan
									</a>
								</div>
							</div>
							</form>
						</div>
						<!--begin::Step 1-->
					</div>
					<!--end::Group-->
					<!--begin::Actions-->
					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
						<div class="d-flex flex-stack">
							<!--begin::Wrapper-->
							<div class="me-2">
								<button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
									Back
								</button>
							</div>
							<!--end::Wrapper-->

							<!--begin::Wrapper-->
							<div>
								<button id="btn-submit-jadwal" class="btn btn-primary me-2 flex-shrink-0" data-kt-stepper-action="submit">
									<span class="indicator-label" data-kt-translate="btn-submit-jadwal">
										Submit
									</span>
									<span class="indicator-progress">
										<span data-kt-translate="general-progress">Harap tunggu...</span>
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
									</span>
								</button>

								<button type="button" class="btn btn-primary" data-kt-stepper-action="next">
									Continue
								</button>
							</div>
							<!--end::Wrapper-->

						</div>
					</div>
					<!--end::Actions-->
				</div>
				<!--end::Stepper-->
			</div>

		</div>
	</div>
</div>

<!-- modal edit m metode pemeriksaan -->
<div class="modal fade" tabindex="-1" id="modal_edit_bangunan">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Edit jenis bangunan (Master)</h3>

				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
					<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
				</div>
				<!--end::Close-->
			</div>

			<div class="modal-body">
				<form method="POST" class="form w-100" id="form-edit-m-bangunan">
					<input type="text" hidden name="edit_id_jenis_bangunan">
					<div class="fv-row mb-5 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
						<label for="edit_nama_bangunan" class="required form-label">Jenis bangunan</label>
						<input type="text" class="form-control form-control-solid" name="edit_nama_bangunan" placeholder="Masukkan jenis bangunan" />
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
				<div class="d-flex flex-stack">
					<button id="btn-submit-edit-m-bangunan" class="btn btn-primary me-2 flex-shrink-0">
						<span class="indicator-label" data-kt-translate="btn-submit-edit-m-bangunan">
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
