<?php
session_start();
// include '../koneksi.php';
// include '../../../koneksi.php'; // Menyertakan file koneksi dari folder luar
if (!isset($_SESSION['email'])) {
  header('Location: ../../auth/login.php');
  exit();
}
unset($_SESSION['file']);
if (($_SESSION['role'] != 'admin')) {
  header('Location: ../../users/dashboard/index.php');
  # code...
}
require '../../../koneksi.php'; // Menyertakan file koneksi dari folder luar
require '../../../controller/Pegawai.php';
$pasien = new Pegawai();
$data_pasien = $pasien->pasien();
$profile = $pasien->profile();
$unit = $pasien->instalasi();
// var_dump($data_pasien);

// var
?>

<!DOCTYPE html>


<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Data Pasien</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../../../assets/img/favicon/favicon.ico" />

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


</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
              <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                  <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                  <path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path>
                  <path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path>
                  <path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path>
                </defs>
                <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                      <g id="Mask" transform="translate(0.000000, 8.000000)">
                        <mask id="mask-2" fill="white">
                          <use xlink:href="#path-1"></use>
                        </mask>
                        <use fill="#696cff" xlink:href="#path-1"></use>
                        <g id="Path-3" mask="url(#mask-2)">
                          <use fill="#696cff" xlink:href="#path-3"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                        </g>
                        <g id="Path-4" mask="url(#mask-2)">
                          <use fill="#696cff" xlink:href="#path-4"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                        </g>
                      </g>
                      <g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                        <use fill="#696cff" xlink:href="#path-5"></use>
                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                      </g>
                    </g>
                  </g>
                </g>
              </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">sirekam</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
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
          <li class="menu-item active">
            <a href="../data-pasien/index.php" class="menu-link">
              <i class="menu-icon bi-heart-pulse "></i>
              <div data-i18n="Account Settings">Data Pasien</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="../data-pegawai/index.php" class="menu-link">
              <i class="menu-icon bi-person-badge"></i>
              <div data-i18n="Account Settings">Data Pegawai</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="../riwayat-file/index.php" class="menu-link">
              <i class="menu-icon bi bi-clipboard"></i>
              <div data-i18n="Account Settings">Riwayat File</div>
            </a>
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
                    <a class="dropdown-item" href="auth-login-basic.html">
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
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table /</span>Pasien</h4>

            <!-- Table Data Pasien -->
            <div class="card shadow mb-3">
              <div class="card-header py-3 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insertModal">
                  <i class="bi bi-person"></i>
                  <i class="bi bi-plus"></i>
                </button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">JK</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Kepesertaan</th>
                        <th class="text-center">No RM</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Tgl. Masuk</th>
                        <th class="text-center">Tgl. Keluar</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">JK</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Kepesertaan</th>
                        <th class="text-center">No RM</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Tgl. Masuk</th>
                        <th class="text-center">Tgl. Keluar</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data_pasien as $pasien) { ?>
                        <tr>
                          <td class="text-center"><?= $no++; ?></td>
                          <td class="text-center"><?= $pasien['nama'] ?></td>
                          <td class="text-center"><?= $pasien['jenis_kelamin'] ?></td>
                          <td class="text-center"><?= $pasien['alamat'] ?></td>
                          <td class="text-center"><?= $pasien['jenis_kepesertaan'] ?></td>
                          <td class="text-center"><?= $pasien['no_rm'] ?></td>
                          <td class="text-center"><?= $pasien['instalasi'] ?></td>
                          <!-- <<<<<<<<<<<<<<  ✨ Codeium Command 🌟 >>>>>>>>>>>>>>>> -->
                          <td class="text-center"><?= date('d-m-Y', strtotime($pasien['tgl_masuk'])) ?></td>

                          <!-- <<<<<<<  663682a2-cbb2-4ad6-837e-4c564320656c  >>>>>>> -->
                          <td class="text-center"><?= date('d-m-Y', strtotime($pasien['tgl_keluar'])) ?></td>
                          <td class="text-center">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#showModal" onclick="showData(<?= htmlspecialchars(json_encode($pasien), ENT_QUOTES, 'UTF-8'); ?>)">
                              <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#editModal" onclick="editData(<?= htmlspecialchars(json_encode($pasien), ENT_QUOTES, 'UTF-8'); ?>)">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button id="deleteButton" class="btn btn-danger" onclick="deleteData(<?= $pasien['id_pasien'] ?>)">
                              <i class="bi bi-trash"></i>
                            </button>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--/ Responsive Table -->

            <!-- style modal -->
            <style>
              .modal-dialog {
                max-width: 50%;

              }
            </style>

            <!-- Modal Insert data pasien-->
            <div class="modal fade" id="insertModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Pasien</h4>
                    <a data-dismiss="modal">
                      <i class="bi bi-x"></i>
                    </a>
                  </div>

                  <!-- Modal Body -->
                  <div class="modal-body">
                    <form id="insertForm" action="../../../controller/Pasien.php" method="POST" enctype="multipart/form-data">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Lengkap" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="nik">NIK <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukan NIK" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="age">Tanggal Lahir <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="age" name="tanggal_lahir" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                              <select name="gender" class="form-control" id="gender" placeholder="Pilih" required>
                                <option value="">Pilih</option>
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                              </select>
                            </div>
                          </div>
                          <input type="hidden" name="action" value="insert">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="no_rm">No. RM <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="no_rm" name="no_rm" placeholder="Masukan No. RM" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="instalasi">Unit Terakhir <span class="text-danger">*</span></label>
                              <select name="id_unit" class="form-control" id="instalasi" placeholder="Pilih Instalasi" required>
                                <option value="">Pilih Unit/Instalasi</option>
                                <?php foreach ($unit as $key) { ?>
                                  <option value="<?= $key['id'] ?>"><?= $key['instalasi'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="kepesertaan">Jenis Kepesertaan <span class="text-danger">*</span></label>
                              <select name="kepesertaan" class="form-control" id="kepesertaan" placeholder="Pilih" required>
                                <option value="">Pilih</option>
                                <option value="BPJS">BPJS</option>
                                <option value="Umum">Umum</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="address">Alamat <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="address" name="alamat" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="vital">Vital Sign<span class="text-danger">*</span></label>
                              <div class="form-group row">
                                <label for="td" class="col-sm-1 col-form-label">TD:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="td" name="td" placeholder="mmHg" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/mmHg</label>
                              </div>
                              <div class="form-group row">
                                <label for="temperature" class="col-sm-1 col-form-label">T:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="temperatur" name="t" placeholder="°C" required>
                                </div>
                                <label for="temperature" class="col-sm-1 col-form-label ml-0">°C</label>
                              </div>
                              <div class="form-group row">
                                <label for="hr" class="col-sm-1 col-form-label">HR:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="hr" name="hr" placeholder="Minute" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Menit</label>
                              </div>
                              <div class="form-group row">
                                <label for="rr" class="col-sm-1 col-form-label">RR:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="rr" name="rr" placeholder="Menit" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Menit</label>
                              </div>
                              <div class="form-group row">
                                <label for="tb" class="col-sm-1 col-form-label">TB:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="tb" name="tb" placeholder="Cm" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Cm</label>
                              </div>
                              <div class="form-group row">
                                <label for="bb" class="col-sm-1 col-form-label">BB:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="bb" name="bb" placeholder="Kg" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Kg</label>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="diagnosis">Diagnosis <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="diagnosis" name="diagnosis" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="tindakan">Riwayat Tindakan <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="tindakan" name="riwayat_tindakan" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="alergi">Alergi <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="alergi" name="alergi" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="obat">Obat <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="obat" name="obat" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="note">Note Dokter <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="note" name="note_dokter" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="date">Tanggal Masuk <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="date" name="tgl_masuk" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="date">Tanggal Keluar <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="date" name="tgl_keluar" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="formFile" class="form-label">Upload Rekam Medis <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="formFile" name="file_rekammedis">
                          </div>
                          <div class="form-group">
                            <label for="formFile" class="form-label">Upload Hasil Rontgen <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file_hasilrontgen" id="formFile">
                          </div>
                          <div class="form-group">
                            <label for="formFile" class="form-label">Upload Hasil Laboratorium <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="hasil_laboratorium" id="formFile">
                          </div>
                        </div>
                      </div>

                  </div>

                  <!-- Modal Footer -->
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Modal Edit data pasien -->
            <div class="modal fade" id="editModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Edit Data Pasien</h4>
                    <a data-dismiss="modal">
                      <i class="bi bi-x"></i>
                    </a>
                  </div>

                  <!-- Modal Body -->
                  <div class="modal-body">
                    <form action="../../../controller/Pasien.php" method="POST" enctype="multipart/form-data">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="name_edit" name="name" placeholder="Masukan Nama Lengkap" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="nik">NIK <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="nik_edit" name="nik" placeholder="Masukan NIK" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="age">Tanggal Lahir <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="tanggal_lahir_edit" name="tanggal_lahir" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                              <select name="gender" class="form-control" id="gender_edit" placeholder="Pilih" required>
                                <option value="">Pilih</option>
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="no_rm">No. RM <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="no_rm_edit" name="no_rm" placeholder="Masukan No. RM" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="instalasi_edit">Unit Terakhir <span class="text-danger">*</span></label>
                              <select name="id_unit" class="form-control" id="instalasi_edit" placeholder="Pilih Instalasi" required>
                                <option value="">Pilih Unit/Instalasi</option>
                                <?php foreach ($unit as $key) { ?>
                                  <option value="<?= $key['id'] ?>"><?= $key['instalasi'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="kepesertaan_edit">Jenis Kepesertaan <span class="text-danger">*</span></label>
                              <select name="jenis_kepesertaan" class="form-control" id="kepesertaan_edit" placeholder="Pilih" required>
                                <option value="">Pilih</option>
                                <option value="BPJS">BPJS</option>
                                <option value="Umum">Umum</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="address">Alamat <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="alamat_edit" name="alamat" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="vital">Vital Sign<span class="text-danger">*</span></label>
                              <div class="form-group row">
                                <label for="td" class="col-sm-1 col-form-label">TD:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="td_edit" name="td" placeholder="mmHg" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/mmHg</label>
                              </div>
                              <div class="form-group row">
                                <label for="temperature" class="col-sm-1 col-form-label">T:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="temperatur_edit" name="t" placeholder="°C" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">°C</label>
                              </div>
                              <div class="form-group row">
                                <label for="hr" class="col-sm-1 col-form-label">HR:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="hr_edit" name="hr" placeholder="Minute" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Menit</label>
                              </div>
                              <div class="form-group row">
                                <label for="rr" class="col-sm-1 col-form-label">RR:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="rr_edit" name="rr" placeholder="Menit" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Menit</label>
                              </div>
                              <div class="form-group row">
                                <label for="tb" class="col-sm-1 col-form-label">TB:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="tb_edit" name="tb" placeholder="Cm" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Cm</label>
                              </div>
                              <div class="form-group row">
                                <label for="bb" class="col-sm-1 col-form-label">BB:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="bb_edit" name="bb" placeholder="Kg" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Kg</label>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="diagnosis">Diagnosis <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="diagnosis_edit" name="diagnosis" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="tindakan">Riwayat Tindakan <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="tindakan_edit" name="riwayat_tindakan" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="alergi">Alergi <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="alergi_edit" name="alergi" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="obat">Obat <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="obat_edit" name="obat" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="note">Note Dokter <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="note_edit" name="note_dokter" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="tgl_masuk_edit">Tanggal Masuk <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="tgl_masuk_edit" name="tgl_masuk" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="tgl_keluar_edit">Tanggal Keluar <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="tgl_keluar_edit" name="tgl_keluar" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="formFile" class="form-label">Upload Rekam Medis <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file_rekammedis">
                          </div>
                          <input type="hidden" name="id_pasien" id="id_pasien_edit">
                          <input type="hidden" name="action" value="edit">
                          <div class="form-group">
                            <label for="formFile" class="form-label">Upload Hasil Rontgen <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="file_hasilrontgen">
                          </div>
                          <div class="form-group">
                            <label for="formFile" class="form-label">Upload Hasil Laboratorium <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="hasil_laboratorium">
                          </div>
                        </div>
                      </div>

                  </div>

                  <!-- Modal Footer -->
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Modal show data pasien-->
            <div class="modal fade" id="showModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Detail Data Pasien</h4>
                    <a data-dismiss="modal">
                      <i class="bi bi-x"></i>
                    </a>
                  </div>

                  <!-- Modal Body -->
                  <div class="modal-body">
                    <form id="showForm">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="name_detail" name="name" placeholder="Masukan Nama Lengkap" readonly>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="nik">NIK <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="nik_detail" name="nik" placeholder="Masukan NIK">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="age">Tanggal Lahir <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="tanggal_lahirdetil" name="age">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                              <select name="gender" class="form-control" id="gender_detail" placeholder="Pilih">
                                <option value="">Pilih</option>
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="no_rm">No. RM <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="no_rm_detail" name="no_rm" placeholder="Masukan No. RM">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="instalasi">Unit Terakhir </label>
                              <input type="text" class="form-control" id="unit_detail">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="kepesertaan">Jenis Kepesertaan <span class="text-danger">*</span></label>
                              <select name="kepesertaan" class="form-control" id="kepesertaan_detail" placeholder="Pilih">
                                <option value="">Pilih</option>
                                <option value="BPJS">BPJS</option>
                                <option value="Umum">Umum</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="alamat_edit">Alamat <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="address_detail" name="address"></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="vital">Vital Sign<span class="text-danger">*</span></label>
                              <div class="form-group row">
                                <label for="td" class="col-sm-1 col-form-label">TD:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="td_detail" name="td" placeholder="mmHg">
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/mmHg</label>
                              </div>
                              <div class="form-group row">
                                <label for="temperature" class="col-sm-1 col-form-label">T:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="temperatur_detail" name="temperature" placeholder="°C">
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">°C</label>
                              </div>
                              <div class="form-group row">
                                <label for="hr" class="col-sm-1 col-form-label">HR:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="hr_detail" name="hr" placeholder="Minute" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Menit</label>
                              </div>
                              <div class="form-group row">
                                <label for="rr" class="col-sm-1 col-form-label">RR:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="rr_detail" name="rr" placeholder="Menit" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Menit</label>
                              </div>
                              <div class="form-group row">
                                <label for="tb" class="col-sm-1 col-form-label">TB:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="tb_detail" name="tb" placeholder="Cm" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Cm</label>
                              </div>
                              <div class="form-group row">
                                <label for="bb" class="col-sm-1 col-form-label">BB:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="bb_detail" name="bb" placeholder="Kg" required>
                                </div>
                                <label for="td" class="col-sm-1 col-form-label ml-0">/Kg</label>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="diagnosis">Diagnosis <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="diagnosis_detail" name="diagnosis" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="tindakan">Riwayat Tindakan <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="tindakan_detail" name="tindakan" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="alergi">Alergi <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="alergi_detail" name="alergi" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="obat">Obat <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="obat_detail" name="obat" required></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="note">Note Dokter <span class="text-danger">*</span></label>
                              <textarea class="form-control" id="note_detail" name="note" required readonly></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="date">Tanggal Masuk <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="tgl_masuk_detail" name="date" required readonly>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="date">Tanggal Keluar <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="tgl_keluar_detail" name="date" required readonly>
                            </div>
                          </div>
                    </form>
                    <div class="container mt-5">
                      <div class="d-flex justify-content-between">
                        <form action="../../../controller/Pasien.php" method="POST">
                          <div class="form-group">

                            <input type="hidden" name="file_jenis" value="rekam_medis">
                            <input type="hidden" name="file" id="rekam_medis_file">
                            <input type="hidden" name="action" value="lihat_file">
                            <h6>Hasil Rekam Medis</h6>
                            <button class="btn btn-pdf btn-primary" type="submit">
                              <i class="bi bi-file-earmark-pdf"></i> Buka PDF
                            </button>
                          </div>
                        </form>
                        <form action="../../../controller/Pasien.php" method="POST">

                          <input type="hidden" name="file_jenis" value="rontgen">
                          <input type="hidden" name="file" id="rontgen_file">
                          <input type="hidden" name="action" value="lihat_file">

                          <div class="form-group mx-2">
                            <h6>Hasil Rontgen</h6>
                            <button type="submit" class="btn btn-pdf btn-primary">
                              <i class="bi bi-file-earmark-pdf"></i> Buka PDF
                            </button>
                          </div>
                        </form>
                        <form action="../../../controller/Pasien.php" method="POST">
                          <input type="hidden" name="file_jenis" value="laboratorium">
                          <input type="hidden" name="file" id="laboratorium_file">
                          <input type="hidden" name="action" value="lihat_file">
                          <div class="form-group">
                            <h6>Hasil Laboratorium</h6>
                            <button class="btn btn-pdf btn-primary" type="submit">
                              <i class="bi bi-file-earmark-pdf"></i> Buka PDF
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <!-- Modal Footer -->
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button> -->
              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- / Content -->
      <form action="../../../controller/Pasien.php" id="formDelete" method="POST">
        <input type="hidden" name="id_pasien" id="idDelete">
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
    // document.getElementById('deleteButton').addEventListener('click', function() {
    //   const userId = this.getAttribute('data-id');
    //   Swal.fire({
    //     title: 'Apakah Anda Yakin?',
    //     text: "Anda igin menghapus data ini!",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Ya, Hapus!'
    //   }).then((result) => {
    //     if (result.isConfirmed) {
    //       window.location.href = 'delete.php?id=' + userId;
    //     }
    //   });
    // });

    function deleteData(id) {

      Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Anda igin menghapus data ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('idDelete').value = id;
          document.getElementById('formDelete').submit();
        }
      });
    }



    document.addEventListener('DOMContentLoaded', function() {
      const success = <?php echo json_encode(isset($_SESSION['success']) ? $_SESSION['success'] : ''); ?>;
      const logout = <?php echo json_encode(isset($_SESSION['logout']) ? $_SESSION['logout'] : ''); ?>;
      const error = <?php echo json_encode(isset($_SESSION['error']) ? $_SESSION['error'] : ''); ?>;

      if (success) {
        Swal.fire({
          icon: 'success',
          title: 'Sukses',
          text: success,
        });
        <?php unset($_SESSION['success']); ?>
      }

      if (error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error,
        });
        <?php unset($_SESSION['error']); ?>
      }
    });
  </script>

  <!-- modal insert -->
  <script>
    // Handle form submission
    // document.getElementById('insertForm').addEventListener('submit', function(event) {
    //   event.preventDefault();
    //   // Perform your insert operation here, e.g., send data to the server
    //   alert('Form submitted!');
    //   // Close the modal
    //   $('#insertModal').modal('hide');
    // });
  </script>

  <!-- modal edit -->
  <!-- <script>
    // Handle form submission
    document.getElementById('editForm').addEventListener('submit', function(event) {
      event.preventDefault();
      // Perform your insert operation here, e.g., send data to the server
      // alert('Form submitted!');
      // // Close the modal
      // $('#editModal').modal('hide');
    });
  </script> -->

  <!-- modal show -->
  <script>
    // Handle form submission
    document.getElementById('showForm').addEventListener('submit', function(event) {
      event.preventDefault();
      // Perform your insert operation here, e.g., send data to the server
      alert('Form submitted!');
      // Close the modal
      $('#showModal').modal('hide');
    });


    function showData(data) {
      document.getElementById('name_detail').value = data.nama;
      document.getElementById('nik_detail').value = data.nik;
      document.getElementById('tanggal_lahirdetil').value = data.tanggal_lahir;
      document.getElementById('gender_detail').value = data.jenis_kelamin;
      document.getElementById('no_rm_detail').value = data.no_rm;
      document.getElementById('unit_detail').value = data.instalasi;
      document.getElementById('kepesertaan_detail').value = data.jenis_kepesertaan;
      document.getElementById('address_detail').value = data.alamat;
      document.getElementById('td_detail').value = data.td;
      document.getElementById('temperatur_detail').value = data.t;
      document.getElementById('hr_detail').value = data.hr;
      document.getElementById('rr_detail').value = data.rr;
      document.getElementById('tb_detail').value = data.tb;
      document.getElementById('bb_detail').value = data.bb;
      document.getElementById('note_detail').value = data.note_dokter;
      document.getElementById('diagnosis_detail').value = data.diagnosis;
      document.getElementById('tindakan_detail').value = data.riwayat_tindakan;
      document.getElementById('alergi_detail').value = data.alergi;
      document.getElementById('obat_detail').value = data.obat;
      document.getElementById('tgl_masuk_detail').value = data.tgl_masuk;
      document.getElementById('tgl_keluar_detail').value = data.tgl_keluar;
      document.getElementById('rekam_medis_file').value = data.file_rekammedis;
      document.getElementById('laboratorium_file').value = data.hasil_laboratorium;
      document.getElementById('rontgen_file').value = data.file_hasilrontgen;

      // Update the href attribute for PDF links with the correct paths
      // document.getElementById('rekam_medis_link').href = '../../../controller/uploads/rekammedis/' + data.file_rekammedis;
      // document.getElementById('rontgen_link').href = '../../../controller/uploads/rontgen/' + data.file_hasilrontgen;
      // document.getElementById('laboratorium_link').href = '../../../controller/uploads/laboratorium/' + data.hasil_laboratorium;


    }



    function editData(data) {
      console.log(data);
      document.getElementById('id_pasien_edit').value = data.id_pasien;
      document.getElementById('name_edit').value = data.nama;
      document.getElementById('nik_edit').value = data.nik;
      document.getElementById('tanggal_lahir_edit').value = data.tanggal_lahir;
      document.getElementById('gender_edit').value = data.jenis_kelamin;
      document.getElementById('no_rm_edit').value = data.no_rm;
      document.getElementById('instalasi_edit').value = data.id_unit;
      document.getElementById('kepesertaan_edit').value = data.jenis_kepesertaan;
      document.getElementById('alamat_edit').value = data.alamat;
      document.getElementById('td_edit').value = data.td;
      document.getElementById('temperatur_edit').value = data.t;
      document.getElementById('hr_edit').value = data.hr;
      document.getElementById('rr_edit').value = data.rr;
      document.getElementById('tb_edit').value = data.tb;
      document.getElementById('bb_edit').value = data.bb;
      document.getElementById('note_edit').value = data.note_dokter;
      document.getElementById('diagnosis_edit').value = data.diagnosis;
      document.getElementById('tindakan_edit').value = data.riwayat_tindakan;
      document.getElementById('alergi_edit').value = data.alergi;
      document.getElementById('obat_edit').value = data.obat;
      document.getElementById('tgl_masuk_edit').value = data.tgl_masuk;
      document.getElementById('tgl_keluar_edit').value = data.tgl_keluar;

      // Update the href attribute for PDF links with the correct paths

    }
  </script>



</body>

</html>