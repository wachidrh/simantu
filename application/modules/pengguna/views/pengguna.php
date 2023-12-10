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
