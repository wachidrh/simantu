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
						<table>
							<tr>
								<th>Jenis Peralatan</th>
								<td class="px-2">:</th>
								<td><?= $periksa['nama_lokasi'] ?></th>
							</tr>
							<tr>
								<th>Lokasi</th>
								<td class="px-2">:</th>
								<td><?= $periksa['nama_lokasi'] ?></th>
							</tr>
							<tr>
								<th>Tanggal Pemeriksaan</th>
								<td class="px-2">:</th>
								<td><?= $periksa['nama_lokasi'] ?></th>
							</tr>
							<tr>
								<th>Periode Pemeriksaan</th>
								<td class="px-2">:</th>
								<td><?= $periksa['nama_lokasi'] ?></th>
							</tr>
						</table>
					</div>
					<div class="card-toolbar">
						<div class="d-flex justify-content-end" data-kt-bangunan-table-toolbar="base">
							<?php
							$index = array_search($_SESSION['kopeg'], array_column($periksa['penyetuju'], 'approver_id'));

							if ($index !== false && $periksa['penyetuju'][$index]['status'] == "0") {
								echo '<button type="button" class="btn btn-primary" id="setujui_jadwal" data-jadwal="' . $periksa['id_jadwal'] . '"> Setujui Jadwal </button>';
							} elseif ($index !== false && $periksa['penyetuju'][$index]['status'] == "1") {
								echo '<span class="badge badge-success">Disetujui</span>';
							} else {
								$countStatusZero = count(array_filter($periksa['penyetuju'], function ($item) {
									return $item['status'] == "1";
								}));
								if ($countStatusZero < sizeof($periksa['penyetuju'])) {
									echo '<span class="badge badge-warning">Belum Disetujui</span>';
								} else {
									echo '<span class="badge badge-success">Disetujui</span>';
								}
							}
							?>
						</div>
					</div>
				</div>
				<div class="card-body pt-0">
					<div class="table-responsive">
						<table class="table table-bordered gy-1 table-sm">
							<thead>
								<tr class="fw-bold fs-6 text-gray-800 text-center align-middle">
									<th>No</th>
									<th>Item Pemeriksaan</th>
									<th>Kriteria Pemeriksaan</th>
									<th>Metode Pemeriksaan</th>
									<th>Hasil Pemeriksaan</th>
									<th>Keterangan</th>
								</tr>
								<tr class="fw-bold fs-6 text-gray-800 text-center align-middle">
									<th>(1)</th>
									<th>(2)</th>
									<th>(3)</th>
									<th>(4)</th>
									<th>(5)</th>
									<th>(6)</th>
								</tr>
							</thead>
							<tbody>
								<?php
								echo '<pre>';
								var_dump($periksa);
								echo '</pre>';
								$last_id_bangunan = 0;
								$last_id_peralatan = 0;
								$last_start_bangunan = 1;
								$last_start_peralatan = 1;

								foreach ($periksa['item_periksa'] as $key => $val) {
									if ($last_id_bangunan != $val['id_jenis_bangunan']) {
								?>
										<tr>
											<td>
												<h6>
													<ol style="margin:0" type="A">
														<li><?= ($val['id_jenis_bangunan'] != $last_id_bangunan) ? "" : "" ?></li>
													</ol>
												</h6>
											</td>
											<td>
												<h6><?= $val['nama_bangunan'] ?></h6>
											</td>
										</tr>
									<?php
										$last_id_bangunan = (int)$val['id_jenis_bangunan'];
										$last_start_bangunan++;
									}
									if ($last_id_peralatan != $val['id_jenis_peralatan']) {
									?>
										<tr>
											<td>
												<h6>
													<ol style="margin:0" type="I" start="<?= $last_start_peralatan ?>">
														<li><?= ($val['id_jenis_peralatan'] != $last_id_peralatan) ? "" : "" ?></li>
													</ol>
												</h6>
											</td>
											<td>
												<h6><?= $val['nama'] ?></h6>
											</td>
										</tr>
									<?php
										$last_start_peralatan++;
									}
									$last_id_peralatan = (int)$val['id_jenis_peralatan'];
									?>
									<tr>
										<td></td>
										<td>- <?= $val['nama_item'] ?></td>
										<td><?= $val['kriteria'] ?></td>
										<td><?= $val['metode'] ?></td>
										<td><?= $val['hasil_periksa'] ?></td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>