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
								<th>Lokasi</th>
								<td class="px-2">:</th>
								<td><?= $jadwal['nama_lokasi'] ?></th>
							</tr>
							<tr>
								<th>Triwulan</th>
								<td class="px-2">:</th>
								<td><?= $jadwal['triwulan'] ?></th>
							</tr>
							<tr>
								<th>Tahun</th>
								<td class="px-2">:</th>
								<td><?= $jadwal['tahun_jadwal'] ?></th>
							</tr>
						</table>
					</div>
					<div class="card-toolbar">
						<div class="d-flex justify-content-end" data-kt-bangunan-table-toolbar="base">
							<?php
							$index = array_search($_SESSION['kopeg'], array_column($jadwal['penyetuju'], 'approver_id'));

							if ($index !== false && $jadwal['penyetuju'][$index]['status'] == "0") {
								echo '<button type="button" class="btn btn-primary" id="setujui_jadwal" data-jadwal="' . $jadwal['id_jadwal'] . '"> Setujui Jadwal </button>';
							} elseif ($index !== false && $jadwal['penyetuju'][$index]['status'] == "1") {
								echo '<span class="badge badge-success">Disetujui</span>';
							} else {
								$countStatusZero = count(array_filter($jadwal['penyetuju'], function ($item) {
									return $item['status'] == "1";
								}));
								if ($countStatusZero < sizeof($jadwal['penyetuju'])) {
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
									<th rowspan="3">No</th>
									<th rowspan="3">JENIS PERALATAN ELEKTROMEKANIS</th>
									<th rowspan="3">PERIODE PEMERIKSAAN</th>
									<th colspan="15">Bulan</th>
									<th rowspan="3">KETERANGAN</th>
								</tr>
								<tr class="fw-bold fs-6 text-gray-800 text-center">
									<?php
									foreach ($jadwal['bulan_triwulan'] as $key => $b) {
									?>
										<th colspan="5"><?= $b['bulan'] ?></th>
									<?php
									}
									?>

								</tr>
								<tr class="fw-bold fs-6 text-gray-800 text-center">
									<th>I</th>
									<th>II</th>
									<th>III</th>
									<th>IV</th>
									<th>V</th>
									<th>I</th>
									<th>II</th>
									<th>III</th>
									<th>IV</th>
									<th>V</th>
									<th>I</th>
									<th>II</th>
									<th>III</th>
									<th>IV</th>
									<th>V</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$last_id_bangunan = 0;
								$last_id_peralatan = 0;
								$last_id_item = 0;
								$last_start_bangunan = 1;
								$last_start_peralatan = 1;

								foreach ($jadwal['item_jadwal'] as $key => $item) {
									if ($item['id_jenis_bangunan'] != $last_id_bangunan) {
								?>
										<tr>
											<td>
												<ol style="margin:0" type="A" start="<?= $last_start_bangunan ?>">
													<li><?= ($item['id_jenis_bangunan'] != $last_id_bangunan) ? "" : "" ?></li>
												</ol>
											</td>
											<td><b><?= ($item['id_jenis_bangunan'] != $last_id_bangunan) ? $item['nama_bangunan'] : "" ?></b></td>
											<td colspan="16"></td>
											<td></td>
										</tr>
									<?php
										$last_start_bangunan++;
										$last_start_peralatan = 1;
									}

									if ($item['id_jenis_peralatan'] != $last_id_peralatan) {
									?>
										<tr>
											<td>
												<ol style="margin:0" type="1" start="<?= $last_start_peralatan ?>">
													<li></li>
												</ol>
											</td>
											<td><b><?= ($item['id_jenis_peralatan'] != $last_id_peralatan) ? $item['nama'] : "" ?></b></td>
											<td colspan="16"></td>
											<td></td>
										</tr>
									<?php
										$last_start_peralatan++;
									}

									if ($item['id_item_peralatan'] != $last_id_item) {
									?>
										<tr>
											<td></td>
											<td>- <?= $item['nama_item'] ?></td>
											<td><?= $item['periode'] ?></td>
											<?php
											$periode = $item['periode'];
											foreach ($jadwal['bulan_triwulan'] as $key => $b) {
												$weeks = get_weeks($item['tgl_periksa'], 'sunday');
												$month = date('m', strtotime($item['tgl_periksa']));
												$date_fix = in_array($periode, ['3BL', '6BL', '1TH', '2TH', '4TH', '5TH']);

												$td1 = ($periode == "SB" && $weeks == 1) ? "SB" : ($periode == 'SM' ? "SM" : (($date_fix && $month == $b['nomor_bulan'] && $weeks == 1) ? $periode : ($periode == 'SH' ? 'SH' : "")));
												$td2 = ($periode == "SB" && $weeks == 2) ? "SB" : ($periode == 'SM' ? "SM" : (($date_fix && $month == $b['nomor_bulan'] && $weeks == 2) ? $periode : ($periode == 'SH' ? 'SH' : "")));
												$td3 = ($periode == "SB" && $weeks == 3) ? "SB" : ($periode == 'SM' ? "SM" : (($date_fix && $month == $b['nomor_bulan'] && $weeks == 3) ? $periode : ($periode == 'SH' ? 'SH' : "")));
												$td4 = ($periode == "SB" && $weeks == 4) ? "SB" : ($periode == 'SM' ? "SM" : (($date_fix && $month == $b['nomor_bulan'] && $weeks == 4) ? $periode : ($periode == 'SH' ? 'SH' : "")));
												$td5 = ($periode == "SB" && $weeks >= 5) ? "SB" : ($periode == 'SM' ? "SM" : (($date_fix && $month == $b['nomor_bulan'] && $weeks >= 5) ? $periode : ($periode == 'SH' ? 'SH' : "")));

											?>
												<td><?= $td1 ?></td>
												<td><?= $td2 ?></td>
												<td><?= $td3 ?></td>
												<td><?= $td4 ?></td>
												<td><?= $td5 ?></td>
											<?php
											}
											?>
											<td></td>
										</tr>
								<?php
									}

									$last_id_bangunan = $item['id_jenis_bangunan'];
									$last_id_peralatan = $item['id_jenis_peralatan'];
									$last_id_item = $item['id_item_peralatan'];
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