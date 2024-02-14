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
					<!--begin::Alert-->
					<div class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row p-5 mb-10">
						<!--begin::Icon-->
						<i class="ki-duotone ki-notification-bing fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
						<!--end::Icon-->

						<!--begin::Wrapper-->
						<div class="d-flex flex-column pe-0 pe-sm-10">
							<!--begin::Title-->
							<h4 class="fw-semibold">Berhasil scan!</h4>
							<!--end::Title-->

							<!--begin::Content-->
							<span>Anda melakukan pemindaian NFC di <br/> <b><?= $bangunan['bangunan']['nama_peralatan'] .' - '. $bangunan['bangunan']['nama_bangunan'].' - '.$bangunan['bangunan']['nama_lokasi']?></b>. <br/>Silakan pilih periode pemeriksaan untuk pengisian form!</span>
							<!--end::Content-->
						</div>
						<!--end::Wrapper-->

						<!--begin::Close-->
						<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
							<i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
						</button>
						<!--end::Close-->
					</div>
					<!--end::Alert-->
					<div class="text-center">
					<?php
					if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1' || $_SERVER['HTTP_HOST'] == 'localhost:8000') {
						$form_url = '/simantu/pemeriksaan/elektromekanis/input-form';
					} else {
						$form_url = '/pemeriksaan/elektromekanis/input-form';
					  }
					?>
					<form id="redirectForm" action="<?= $form_url ?>" method="post">
						<input type="hidden" name="periode" value="">
						<input type="hidden" name="id_bangunan" value="">
						<input type="hidden" name="id_peralatan" value="">
						<!-- Add more parameters as needed -->
					</form>
						<a href="#" class="btn btn-primary mb-4 col-12 col-md-3 cek-jadwal" data-periode="1" data-id-bangunan="<?= $bangunan['bangunan']['id_m_jenis_bangunan'] ?>" data-id-peralatan="<?= $bangunan['bangunan']['id_m_jenis_peralatan'] ?>">
							<i class="ki-duotone ki-pencil fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							Setiap Operasi
						</a>
						<a href="#" class="btn btn-primary mb-4 col-12 col-md-3 cek-jadwal" data-periode="2" data-id-bangunan="<?= $bangunan['bangunan']['id_m_jenis_bangunan'] ?>" data-id-peralatan="<?= $bangunan['bangunan']['id_m_jenis_peralatan'] ?>">
							<i class="ki-duotone ki-pencil fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							Setiap Hari
						</a>
						<a href="#" class="btn btn-primary mb-4 col-12 col-md-3 cek-jadwal" data-periode="3" data-id-bangunan="<?= $bangunan['bangunan']['id_m_jenis_bangunan'] ?>" data-id-peralatan="<?= $bangunan['bangunan']['id_m_jenis_peralatan'] ?>">
							<i class="ki-duotone ki-pencil fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							Setiap Minggu
						</a>
						<a href="#" class="btn btn-primary mb-4 col-12 col-md-3 cek-jadwal" data-periode="4" data-id-bangunan="<?= $bangunan['bangunan']['id_m_jenis_bangunan'] ?>" data-id-peralatan="<?= $bangunan['bangunan']['id_m_jenis_peralatan'] ?>">
							<i class="ki-duotone ki-pencil fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							Setiap Bulan
						</a>
						<a href="#" class="btn btn-primary mb-4 col-12 col-md-3 cek-jadwal" data-periode="5" data-id-bangunan="<?= $bangunan['bangunan']['id_m_jenis_bangunan'] ?>" data-id-peralatan="<?= $bangunan['bangunan']['id_m_jenis_peralatan'] ?>">
							<i class="ki-duotone ki-pencil fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							Setiap 3 Bulan
						</a>
						<a href="#" class="btn btn-primary mb-4 col-12 col-md-3 cek-jadwal" data-periode="6" data-id-bangunan="<?= $bangunan['bangunan']['id_m_jenis_bangunan'] ?>" data-id-peralatan="<?= $bangunan['bangunan']['id_m_jenis_peralatan'] ?>">
							<i class="ki-duotone ki-pencil fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							Setiap 6 Bulan
						</a>
						<a href="#" class="btn btn-primary mb-4 col-12 col-md-3 cek-jadwal" data-periode="7" data-id-bangunan="<?= $bangunan['bangunan']['id_m_jenis_bangunan'] ?>" data-id-peralatan="<?= $bangunan['bangunan']['id_m_jenis_peralatan'] ?>">
							<i class="ki-duotone ki-pencil fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							Setiap Tahun
						</a>
						<a href="#" class="btn btn-primary mb-4 col-12 col-md-3 cek-jadwal" data-periode="8" data-id-bangunan="<?= $bangunan['bangunan']['id_m_jenis_bangunan'] ?>" data-id-peralatan="<?= $bangunan['bangunan']['id_m_jenis_peralatan'] ?>">
							<i class="ki-duotone ki-pencil fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							Setiap 2 Tahun
						</a>
						<a href="#" class="btn btn-primary mb-4 col-12 col-md-3 cek-jadwal" data-periode="9" data-id-bangunan="<?= $bangunan['bangunan']['id_m_jenis_bangunan'] ?>" data-id-peralatan="<?= $bangunan['bangunan']['id_m_jenis_peralatan'] ?>">
							<i class="ki-duotone ki-pencil fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							Setiap 4 Tahun
						</a>
						<a href="#" class="btn btn-primary mb-4 col-12 col-md-3 cek-jadwal" data-periode="10" data-id-bangunan="<?= $bangunan['bangunan']['id_m_jenis_bangunan'] ?>" data-id-peralatan="<?= $bangunan['bangunan']['id_m_jenis_peralatan'] ?>">
							<i class="ki-duotone ki-pencil fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							Setiap 5 Tahun
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
