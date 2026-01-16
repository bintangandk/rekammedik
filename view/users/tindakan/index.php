<?php

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../../auth/login.php');
    exit();
}

require '../../../koneksi.php'; // Menyertakan file koneksi dari folder luar
require '../../../controller/Pegawai.php';

include '../../../controller/tindakan.php';
include '../../../controller/dic_diagnosis.php';
include '../../../controller/dic_medikamentosa.php';
include '../../../controller/dic_tindakan.php';

$pegawai = new Pegawai();
$profile = $pegawai->profile();

function getAllPasien($db)
{
    $sql = "SELECT * FROM pasien";
    return $db->showData($sql);
}

$tindakans = getAllTindakans($db);
$diagnosisList = getAllDiagnosis($db);
$medikamentosaList = getAllMedikamentosa($db);
$tindakanList = getAllTindakan($db);
$pasienList = getAllPasien($db);

?>

<style>
    .swal2-container {
        z-index: 20000 !important;
    }

    .colored-toast.swal2-icon-error {
        background-color: #ff3e1d !important;
    }

    .colored-toast.swal2-icon-success {
        background-color: #28a745 !important;
    }
</style>

<!DOCTYPE html>


<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Tindakan</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../../assets/img/favicon/logo-si.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../../../assets/vendor/fonts/boxicons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">


    <!-- Modal -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Custom styles for this page -->
    <link href="../../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../../assets/js/config.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- style modal -->
    <style>
        .modal-dialog {
            max-width: auto;

        }

        .table-responsive {
            overflow: visible !important;
        }

        .table-responsive .dropdown-menu {
            position: absolute !important;
            z-index: 1050 !important;
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="d-flex justify-content-start align-items-center">
                    <span class="app-brand-logo demo">
                        <img src="../../../assets/img/favicon/logo-si.png" alt="Logo" width="90">
                    </span>
                    <span class="app-brand-text demo menu-text fw-bolder ms-0  text-capitalize">DiRec</span>
                </div>
                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item">
                        <a href="../dashboard/index.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">menu</span>
                    </li>
                    <li class="menu-item">
                        <a href="../data-pasien/index.php" class="menu-link">
                            <i class="menu-icon bi-heart-pulse "></i>
                            <div data-i18n="Account Settings">Data Pasien</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="../riwayat-file/index.php" class="menu-link">
                            <i class="menu-icon bi bi-clipboard"></i>
                            <div data-i18n="Account Settings">Riwayat File</div>
                        </a>
                    </li>
                    <li class="menu-item dropdown">
                        <a href="#" class="menu-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="menu-icon bi bi-book"></i>
                            <div data-i18n="Account Settings">Aktivitas</div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../konsultasi/index.php">Konsultasi</a></li>
                            <li><a class="dropdown-item" href="../tindakan/index.php">Tindakan</a></li>
                        </ul>
                    </li>
                    <li class="menu-item dropdown">
                        <a href="#" class="menu-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="menu-icon bi bi-bookmark"></i>
                            <div data-i18n="Account Settings">Dictionary</div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../dic-medikamentosa/index.php">Medikamentosa</a></li>
                            <li><a class="dropdown-item" href="../dic-diagnosis/index.php">Diagnosis</a></li>
                            <li><a class="dropdown-item" href="../dic-tindakan/index.php">Tindakan</a></li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <span class="fw-semibold"><?php echo date('l, d F Y'); ?></span>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <?php if ($profile['gambar'] == 'profile.jpg') { ?>
                                            <img src="../../../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                        <?php } else { ?>
                                            <img src="../../../controller/uploads/profile/<?= $profile['gambar'] ?>" alt class="w-px-40 h-auto rounded-circle" />
                                        <?php } ?>

                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <?php if ($profile['gambar'] == 'profile.jpg') { ?>
                                                            <img src="../../../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                                        <?php } else { ?>
                                                            <img src="../../../controller/uploads/profile/<?= $profile['gambar'] ?>" alt class="w-px-40 h-auto rounded-circle" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="grow">
                                                    <span class="fw-semibold d-block"><?= $profile['Nama'] ?></span>
                                                    <!-- sesuai role -->
                                                    <small class="text-muted"><?= $profile['role'] ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="../profile/index.php">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item" id="logout-link">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl grow container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table /</span>Tindakan</h4>

                        <!-- Table Konsultasi -->
                        <div class="card shadow mb-3">
                            <div class="card-header py-3 d-flex justify-content-end gap-2">
                                <!-- Insert Button -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
                                    <i class="bi bi-pencil"></i>
                                    <i class="bi bi-plus"></i>
                                </button>
                                <!-- Print Button -->
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#printModalTindakan">
                                    <i class="bi bi-printer"></i>
                                    Cetak
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">No RM</th>
                                                <th class="text-center">Pasien</th>
                                                <th class="text-center">Jenis Tindakan</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Durasi</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">No RM</th>
                                                <th class="text-center">Pasien</th>
                                                <th class="text-center">Jenis Tindakan</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Durasi</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php if (!empty($tindakans)): ?>
                                                <?php $no = 1;
                                                foreach ($tindakans as $data): ?>
                                                    <tr>
                                                        <td class="text-center"><?= $no++; ?></td>
                                                        <td class="text-center"><?= $data['no_rm'] ?></td>
                                                        <td class="text-center"><?= $data['nama_pasien']; ?></td>
                                                        <td class="text-center"><?= $data['nama_tindakan']; ?></td>
                                                        <td class="text-center"><?= $data['tanggal']; ?></td>
                                                        <td class="text-center"><?= $data['durasi']; ?></td>
                                                        <td class="text-center">
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?= $row['id_konsultasi'] ?>"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bi bi-three-dots-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $data['id_tindakan'] ?>">
                                                                    <li>
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal"
                                                                            onclick="editTindakan(<?= htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8'); ?>)">
                                                                            <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#showModal"
                                                                            onclick="showTindakan(<?= htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8'); ?>)">
                                                                            <i class="bi bi-eye me-2 text-primary"></i> Detail
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item text-success" href="#"
                                                                            onclick="printTindakan(<?= $data['id_tindakan'] ?>)">
                                                                            <i class="bi bi-printer me-2"></i> Print
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td class="text-center" colspan="7">Tidak ada data</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/ Responsive Table -->
                        <form action="#" id="formDelete" method="POST">
                            <input type="hidden" name="id" id="idDelete">
                            <input type="hidden" name="action" value="delete">
                        </form>
                        <!-- Modal Insert-->
                        <div class="modal fade" id="insertModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Tambah Tindakan</h4>
                                        <a data-bs-dismiss="modal">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form id="insertForm" action="../../../controller/tindakan.php" method="POST" enctype="multipart/form-data">
                                            <div class="container">
                                                <div class="row">
                                                    <input type="hidden" name="action" value="tambah_data">
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="id_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                                            <select id="id_pasien" name="id_pasien" class="form-control select2" required>
                                                                <option value="">Pilih Pasien</option>
                                                                <?php foreach ($pasienList as $row): ?>
                                                                    <option value="<?= $row['id_pasien']; ?>"><?= $row['nama']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="id_dctindakan">Tindakan<span class="text-danger">*</span></label>
                                                            <select id="id_dctindakan" name="id_dctindakan" class="form-control select2" required>
                                                                <option value="">Pilih Tindakan</option>
                                                                <?php foreach ($tindakanList as $row): ?>
                                                                    <option value="<?= $row['id_dctindakan']; ?>"><?= $row['nama_tindakan']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="id_diagnosis">Diagnosis<span class="text-danger">*</span></label>
                                                            <select id="id_diagnosis" name="id_diagnosis" class="form-control select2" required>
                                                                <option value="">Pilih Diagnosis</option>
                                                                <?php foreach ($diagnosisList as $row): ?>
                                                                    <option value="<?= $row['id_diagnosis']; ?>"><?= $row['nama_diagnosis']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="id_medikamentosa">Medikamentosa<span class="text-danger">*</span></label>
                                                            <select id="id_medikamentosa" name="id_medikamentosa" class="form-control select2" required>
                                                                <option value="">Pilih Medikamentosa</option>
                                                                <?php foreach ($medikamentosaList as $row): ?>
                                                                    <option value="<?= $row['id_medikamentosa']; ?>"><?= $row['nama_generik']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="catatan_dokter">Catatan Dokter<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="catatan_dokter" name="catatan_dokter" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label>Timer Konsultasi</label>
                                                            <h4 id="timerDisplay">00:00:00</h4>
                                                            <input type="hidden" id="durasi" name="durasi">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <button type="button" id="btnMulai" class="btn btn-warning">Mulai</button>
                                                            <button type="button" id="btnSelesai" class="btn btn-secondary" disabled>Selesai</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit-->
                        <div class="modal fade" id="editModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Tindakan</h4>
                                        <a data-bs-dismiss="modal">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form id="editForm" action="../../../controller/tindakan.php" method="POST" enctype="multipart/form-data">
                                            <div class="container">
                                                <div class="row">

                                                    <input type="hidden" name="action" value="update_data">

                                                    <input type="hidden" id="id_edit" name="id_tindakan">

                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="id_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                                            <select id="id_pasien_edit" name="id_pasien" class="form-control select2" required>
                                                                <option value="">-- Pilih Pasien --</option>
                                                                <?php foreach ($pasienList as $row): ?>
                                                                    <option value="<?= $row['id_pasien']; ?>"><?= $row['nama']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="id_dctindakan">Tindakan<span class="text-danger">*</span></label>
                                                            <select id="id_dctindakan_edit" name="id_dctindakan" class="form-control select2" required>
                                                                <option value="">-- Pilih Tindakan--</option>
                                                                <?php foreach ($tindakanList as $row): ?>
                                                                    <option value="<?= $row['id_dctindakan']; ?>"><?= $row['nama_tindakan']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="id_diagnosis">Diagnosis<span class="text-danger">*</span></label>
                                                            <select id="id_diagnosis_edit" name="id_diagnosis" class="form-control select2" required>
                                                                <option value="">-- Pilih Diagnosis--</option>
                                                                <?php foreach ($diagnosisList as $row): ?>
                                                                    <option value="<?= $row['id_diagnosis']; ?>"><?= $row['nama_diagnosis']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="id_medikamentosa">Medikamentosa<span class="text-danger">*</span></label>
                                                            <select id="id_medikamentosa_edit" name="id_medikamentosa" class="form-control select2" required>
                                                                <option value="">-- Pilih Medikamentosa--</option>
                                                                <?php foreach ($medikamentosaList as $row): ?>
                                                                    <option value="<?= $row['id_medikamentosa']; ?>"><?= $row['nama_generik']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="catatan_dokter">Catatan Dokter<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="catatan_dokter_edit" name="catatan_dokter"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" id="tanggal_edit" name="tanggal" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label>Durasi Konsultasi</label>
                                                            <input type="time" class="form-control" id="durasi_edit" name="durasi" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Show-->
                        <div class="modal fade" id="showModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Detail Tindakan</h4>
                                        <a data-bs-dismiss="modal">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form id="insertForm" action="../../../controller/Aktivitas.php" method="POST" enctype="multipart/form-data">
                                            <div class="container">
                                                <div class="row">

                                                    <input type="hidden" id="id_show" name="id_tindakan">

                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="no_rm">No. RM<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="no_rm_show" name="no_rm" readonly></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="nama_pasien">Nama Pasien<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="nama_pasien_show" name="nama_pasien" readonly></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="tindakan">Jenis Tindakan<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="nama_tindakan_show" name="tindakan" readonly></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="diagnosis">Diagnosis<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="nama_diagnosis_show" name="diagnosis" readonly></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="medikamentosa">Medikamentosa<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="nama_medikamentosa_show" name="medikamentosa" readonly></input>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="catatan_dokter">Catatan Dokter<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="catatan_dokter_show" name="catatan_dokter" readonly></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" id="tanggal_show" name="tanggal" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label>Durasi Konsultasi</label>
                                                            <input type="time" class="form-control" id="durasi_show" name="durasi" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Print-->
                        <div class="modal fade" id="printModalTindakan">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">Cetak Data Tindakan</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form id="formPrintTindakan"
                                        action="../../../controller/print_tindakan_range.php"
                                        method="GET"
                                        target="printFrame">

                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label>Tanggal Awal <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="tgl_awal" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Tanggal Akhir <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="tgl_akhir" required>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-printer"></i> Cetak
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Preview PDF -->
                        <div class="modal fade" id="pdfPreviewModal" tabindex="-1">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Preview Laporan Tindakan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body p-0">
                                        <iframe
                                            id="printFrame"
                                            name="printFrame"
                                            style="width:100%; height:80vh; border:none;">
                                        </iframe>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <form action="../../../controller/Aktivitas.php" id="formDelete" method="POST">
        <input type="hidden" name="id" id="idDelete">
        <input type="hidden" name="action" value="delete">
    </form>
    <!-- Footer -->
    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">

                <script>
                    document.write(new Date().getFullYear());
                </script>
            </div>
        </div>
    </footer>
    <!-- / Footer -->

    <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../../../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Page level plugins -->
    <script src="../../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../../assets/js/demo/datatables-demo.js"></script>

    <!-- Delete alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').each(function() {
                let $parentModal = $(this).closest('.modal');
                $(this).select2({
                    width: '100%',
                    dropdownParent: $parentModal.length ? $parentModal : $('body')
                });
            });
        });
    </script>

    <script>
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah tautan default

            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Anda yakin ingin logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi, arahkan ke URL logout
                    window.location.href = "../../../controller/Auth.php?action=logout";
                }
            });
        });
    </script>

    <script>
        let timerInterval;
        let seconds = 0;

        function formatTime(sec) {
            let h = String(Math.floor(sec / 3600)).padStart(2, '0');
            let m = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
            let s = String(sec % 60).padStart(2, '0');
            return `${h}:${m}:${s}`;
        }

        const btnMulai = document.getElementById('btnMulai');
        const btnSelesai = document.getElementById('btnSelesai');
        const btnBatal = document.getElementById('btnBatal');
        const timerDisplay = document.getElementById('timerDisplay');
        const durasiInput = document.getElementById('durasi');

        // Saat klik Mulai
        btnMulai.addEventListener('click', function() {
            seconds = 0;
            timerDisplay.textContent = "00:00:00";
            durasiInput.value = "";

            btnMulai.disabled = true;
            btnSelesai.disabled = false;

            timerInterval = setInterval(() => {
                seconds++;
                timerDisplay.textContent = formatTime(seconds);
            }, 1000);
        });

        // Saat klik Selesai
        btnSelesai.addEventListener('click', function() {
            clearInterval(timerInterval);
            durasiInput.value = formatTime(seconds);

            btnMulai.disabled = false;
            btnSelesai.disabled = true;
        });

        // Saat klik Batal → reset timer
        btnBatal.addEventListener('click', function() {
            clearInterval(timerInterval);
            seconds = 0;
            timerDisplay.textContent = "00:00:00";
            durasiInput.value = "";

            btnMulai.disabled = false;
            btnSelesai.disabled = true;
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editForm = document.getElementById("editForm");

            if (!editForm) return;

            editForm.addEventListener("submit", function(e) {
                e.preventDefault(); // cegah reload default

                const formData = new FormData(editForm);

                fetch("../../../controller/tindakan.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: data.status === "success" ? "success" : "error",
                            title: data.status === "success" ? "Berhasil!" : "Oops...",
                            text: data.message,
                            confirmButtonText: "OK",
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed && data.status === "success") {
                                const modalEl = document.getElementById("editModal");
                                const modal = bootstrap.Modal.getInstance(modalEl);
                                if (modal) modal.hide();

                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            }
                        });
                    })
                    .catch(err => {
                        console.error("❌ Fetch error:", err);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Terjadi kesalahan pada server!",
                            confirmButtonText: "OK"
                        });
                    });
            });
        });
    </script>

    <script>
        function editTindakan(data) {
            document.getElementById('id_edit').value = data.id_tindakan;
            document.getElementById('id_pasien_edit').value = data.id_pasien;
            document.getElementById('id_diagnosis_edit').value = data.id_diagnosis;
            document.getElementById('id_medikamentosa_edit').value = data.id_medikamentosa;
            document.getElementById('id_dctindakan_edit').value = data.id_dctindakan;
            document.getElementById('tanggal_edit').value = data.tanggal;
            document.getElementById('durasi_edit').value = data.durasi;
            document.getElementById('nama_dokter_edit').value = data.nama_dokter;
            document.getElementById('catatan_dokter_edit').value = data.catatan_dokter;
        }

        function showTindakan(data) {
            document.getElementById('id_show').value = data.id_tindakan;
            document.getElementById('no_rm_show').value = data.no_rm;
            document.getElementById('nama_pasien_show').value = data.nama_pasien;
            document.getElementById('nama_tindakan_show').value = data.nama_tindakan;
            document.getElementById('nama_diagnosis_show').value = data.nama_diagnosis;
            document.getElementById('nama_medikamentosa_show').value = data.nama_medikamentosa;
            document.getElementById('tanggal_show').value = data.tanggal;
            document.getElementById('durasi_show').value = data.durasi;
            document.getElementById('catatan_dokter_show').value = data.catatan_dokter;
        }
    </script>

    <script>
        function printTindakan(id) {
            window.open('../../../controller/print_tindakan.php?id=' + id, '_blank');
        }
    </script>

    <script>
        document.getElementById('formPrintTindakan').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch('../../../controller/check_tindakan_range.php?' + new URLSearchParams(formData))
                .then(res => res.json())
                .then(data => {
                    if (data.total == 0) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Tidak ada data konsultasi pada rentang tanggal yang dipilih'
                        });
                        return;
                    }

                    const modal = bootstrap.Modal.getInstance(
                        document.getElementById('printModalTindakan')
                    );
                    modal.hide();

                    form.submit();
                });
        });
    </script>


    <script>
        const iframe = document.getElementById('printFrame');

        iframe.addEventListener('load', function() {
            const previewModal = new bootstrap.Modal(
                document.getElementById('pdfPreviewModal')
            );
            previewModal.show();

            Toast.fire({
                icon: 'success',
                title: 'Laporan berhasil dibuat'
            });
        });
    </script>


    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
</body>

</html>