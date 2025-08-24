<?php

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../../auth/login.php');
    exit();
}

require '../../../koneksi.php'; // Menyertakan file koneksi dari folder luar
require '../../../controller/Pegawai.php';

$pegawai = new Pegawai();
$profile = $pegawai->profile();

?>

<!DOCTYPE html>


<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Konsultasi</title>

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

    <!-- style modal -->
    <style>
        .modal-dialog {
            max-width: auto;

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
                    <li class="menu-item">
                        <a href="../aktivitas/index.php" class="menu-link">
                            <i class="menu-icon bi bi-activity"></i>
                            <div data-i18n="Account Settings">Aktivitas</div>
                        </a>
                    </li>
                    <li class="menu-item active">
                        <a href="../konsultasi/index.php" class="menu-link">
                            <i class="menu-icon bi bi-pencil"></i>
                            <div data-i18n="Account Settings">Konsultasi</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="../tindakan/index.php" class="menu-link">
                            <i class="menu-icon bi bi-book"></i>
                            <div data-i18n="Account Settings">Tindakan</div>
                        </a>
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
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <?php if ($profile['gambar'] == 'profile.jpg') { ?>
                                                            <img src="../../../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                                        <?php } else { ?>
                                                            <img src="../../../controller/uploads/profile/<?= $profile['gambar'] ?>" alt class="w-px-40 h-auto rounded-circle" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
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

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table /</span>Konsultasi</h4>

                        <!-- Table Konsultasi -->
                        <div class="card shadow mb-3">
                            <div class="card-header py-3 d-flex justify-content-end gap-2">
                                <!-- Insert Button -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insertModal">
                                    <i class="bi bi-pencil"></i>
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <!--/ Print Button -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">No RM</th>
                                                <th class="text-center">Pasien</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Durasi</th>
                                                <th class="text-center">Dokter</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">No RM</th>
                                                <th class="text-center">Pasien</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Durasi</th>
                                                <th class="text-center">Dokter</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            <tr>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center">
                                                    <button class="btn btn-warning" data-toggle="modal" data-target="#editModal" onclick="">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-primary" data-toggle="modal" data-target="#showModal" onclick="">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-danger" onclick="">
                                                        <i class="bi bi-printer"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/ Responsive Table -->
                       
                        <!-- Modal Insert-->
                        <div class="modal fade" id="insertModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Tambah Konsultasi</h4>
                                        <a data-dismiss="modal">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form id="insertForm" action="../../../controller/konsultasi.php" method="POST" enctype="multipart/form-data">
                                            <div class="container">
                                                <div class="row">
                                                    <input type="hidden" name="action" value="tambah_data">
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="no_rm">No. RM<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="no_rm" name="no_rm" readonly></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="id_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                                            <select id="id_pasien" name="id_pasien" class="form-control" required>
                                                                <option value="">-- Pilih Dokter --</option>
                                                                <option value="1">dr. Andi Pratama</option>
                                                                <option value="2">dr. Budi Santoso</option>
                                                                <option value="3">dr. Citra Dewi</option>
                                                                <option value="4">dr. Dedi Kurniawan</option>
                                                                <option value="5">dr. Eko Setiawan</option>
                                                                <option value="6">dr. Fitriani</option>
                                                                <option value="7">dr. Guntur</option>
                                                                <option value="8">dr. Hani Kusuma</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="dokter">Nama Dokter <span class="text-danger">*</span></label>
                                                            <select id="dokter" name="dokter" class="form-control" required>
                                                                <option value="">-- Pilih Dokter --</option>
                                                                <option value="1">dr. Andi Pratama</option>
                                                                <option value="2">dr. Budi Santoso</option>
                                                                <option value="3">dr. Citra Dewi</option>
                                                                <option value="4">dr. Dedi Kurniawan</option>
                                                                <option value="5">dr. Eko Setiawan</option>
                                                                <option value="6">dr. Fitriani</option>
                                                                <option value="7">dr. Guntur</option>
                                                                <option value="8">dr. Hani Kusuma</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="diagnosis">Diagnosis<span class="text-danger">*</span></label>
                                                            <select id="diagnosis" name="diagnosis" class="form-control" required>
                                                                <option value="">-- Pilih Diagnosis--</option>
                                                                <option value="1">dr. Andi Pratama</option>
                                                                <option value="2">dr. Budi Santoso</option>
                                                                <option value="3">dr. Citra Dewi</option>
                                                                <option value="4">dr. Dedi Kurniawan</option>
                                                                <option value="5">dr. Eko Setiawan</option>
                                                                <option value="6">dr. Fitriani</option>
                                                                <option value="7">dr. Guntur</option>
                                                                <option value="8">dr. Hani Kusuma</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="medikamentosa">Medikamentosa<span class="text-danger">*</span></label>
                                                            <select id="medikamentosa" name="medikamentosa" class="form-control" required>
                                                                <option value="">-- Pilih Diagnosis--</option>
                                                                <option value="1">dr. Andi Pratama</option>
                                                                <option value="2">dr. Budi Santoso</option>
                                                                <option value="3">dr. Citra Dewi</option>
                                                                <option value="4">dr. Dedi Kurniawan</option>
                                                                <option value="5">dr. Eko Setiawan</option>
                                                                <option value="6">dr. Fitriani</option>
                                                                <option value="7">dr. Guntur</option>
                                                                <option value="8">dr. Hani Kusuma</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="action" value="tambah">
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="no_rm">Catatan Dokter<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="kegiatan" name="kegiatan" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label>Timer Konsultasi</label>
                                                            <h4 id="timerDisplay">00:00:00</h4>
                                                            <!-- Hidden input untuk simpan durasi -->
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
                                        <button type="button" id="btnBatal" class="btn btn-danger" data-dismiss="modal">Batal</button>
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
                                        <h4 class="modal-title">Edit Konsultasi</h4>
                                        <a data-dismiss="modal">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form id="insertForm" action="../../../controller/Aktivitas.php" method="POST" enctype="multipart/form-data">
                                            <div class="container">
                                                <div class="row">
                                                    <input type="hidden" name="action" value="tambah_data">
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="no_rm">No. RM<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="kegiatan" name="kegiatan" required></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="no_rm">Nama Pasien<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="kegiatan" name="kegiatan" required></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="dokter">Nama Dokter <span class="text-danger">*</span></label>
                                                            <select id="dokter" name="dokter" class="form-control" required>
                                                                <option value="">-- Pilih Dokter --</option>
                                                                <option value="1">dr. Andi Pratama</option>
                                                                <option value="2">dr. Budi Santoso</option>
                                                                <option value="3">dr. Citra Dewi</option>
                                                                <option value="4">dr. Dedi Kurniawan</option>
                                                                <option value="5">dr. Eko Setiawan</option>
                                                                <option value="6">dr. Fitriani</option>
                                                                <option value="7">dr. Guntur</option>
                                                                <option value="8">dr. Hani Kusuma</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="diagnosis">Diagnosis<span class="text-danger">*</span></label>
                                                            <select id="diagnosis" name="diagnosis" class="form-control" required>
                                                                <option value="">-- Pilih Diagnosis--</option>
                                                                <option value="1">dr. Andi Pratama</option>
                                                                <option value="2">dr. Budi Santoso</option>
                                                                <option value="3">dr. Citra Dewi</option>
                                                                <option value="4">dr. Dedi Kurniawan</option>
                                                                <option value="5">dr. Eko Setiawan</option>
                                                                <option value="6">dr. Fitriani</option>
                                                                <option value="7">dr. Guntur</option>
                                                                <option value="8">dr. Hani Kusuma</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="medikamentosa">Medikamentosa<span class="text-danger">*</span></label>
                                                            <select id="medikamentosa" name="medikamentosa" class="form-control" required>
                                                                <option value="">-- Pilih Diagnosis--</option>
                                                                <option value="1">dr. Andi Pratama</option>
                                                                <option value="2">dr. Budi Santoso</option>
                                                                <option value="3">dr. Citra Dewi</option>
                                                                <option value="4">dr. Dedi Kurniawan</option>
                                                                <option value="5">dr. Eko Setiawan</option>
                                                                <option value="6">dr. Fitriani</option>
                                                                <option value="7">dr. Guntur</option>
                                                                <option value="8">dr. Hani Kusuma</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="action" value="tambah">
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
                                                            <label>Durasi Konsultasi</label>
                                                            <input type="time" class="form-control" id="durasi" name="durasi" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
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
                                        <h4 class="modal-title">Detail Konsultasi</h4>
                                        <a data-dismiss="modal">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form id="insertForm" action="../../../controller/Aktivitas.php" method="POST" enctype="multipart/form-data">
                                            <div class="container">
                                                <div class="row">
                                                    <input type="hidden" name="action" value="tambah_data">
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="no_rm">No. RM<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="no_rm" name="no_rm" required></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="name">Nama Pasien<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="name" name="name" required></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="dokter">Nama Dokter<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="doter" name="dokter" required></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="diagnosis">Diagnosis<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="diagnosis" name="diagnosis" required></input>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="medikamentosa">Medikamentosa<span class="text-danger">*</span></label>
                                                            <input class="form-control" id="medikamentosa" name="medikamentosa" required></input>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="action" value="tambah">
                                                    <div class="col-md-20">
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
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
                                                            <label>Durasi Konsultasi</label>
                                                            <input type="time" class="form-control" id="durasi" name="durasi" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                        </form>
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

    <!-- modal -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Delete alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        document.getElementById('id_pasien').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var noRm = selectedOption.getAttribute('data-norm');
            document.getElementById('no_rm').value = noRm;
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

</body>

</html>