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
// var_dump($profile);
$data_instalasi = $pegawai->instalasi();
?>



<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>My Profile</title>

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

  <!-- Core CSS -->
  <link rel="stylesheet" href="../../../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../../../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

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
            <h4 class="fw-bold py-3 mb-4"> My Profile</h4>

            <div class="row">
              <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                  <form action="../../../controller/Auth.php" method="POST" enctype="multipart/form-data">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                      <?php if ($profile['gambar'] == 'profile.jpg') {
                        # code...
                      ?>
                        <img src="../../../assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                      <?php } else { ?>
                        <img src="../../../controller/uploads/profile/<?= $profile['gambar']; ?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                      <?php } ?>

                      <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                          <span class="d-none d-sm-block">Edit Foto</span>
                          <i class="bx bx-upload d-block d-sm-none"></i>
                          <input type="file" id="upload" class="account-file-input" name="gambar" hidden accept="image/png, image/jpeg" />
                        </label>

                        <p class="text-muted mb-0">Allowed JPG, PNG, JPEG. Max size 100mb</p>
                      </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                  <input type="hidden" name="action" value="update_profile">
                  <div class="row">
                    <div class="mb-3 col-md-6">
                      <label for="name" class="form-label">Nama Lengkap</label>
                      <input class="form-control" type="text" id="name" name="name" value="<?= $profile['Nama']; ?>" autofocus />
                    </div>
                    <div class="mb-3 col-md-6">
                      <label for="nip" class="form-label">NIP</label>
                      <input class="form-control" type="text" id="nip" name="nip" value="<?= $profile['nip']; ?>" placeholder="john.doe@example.com" />
                    </div>
                    <div class="mb-3 col-md-6">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email" name="email" value="<?= $profile['email']; ?>" />
                    </div>
                    <div class="mb-3 col-md-6">
                      <label class="form-label" for="no_telfon">Phone Number</label>
                      <div class="input-group input-group-merge">
                        <!-- <span class="input-group-text">(+62)</span> -->
                        <input type="text" id="no_telfon" name="no_telfon" class="form-control" value="<?= $profile['no_telfon']; ?>" />
                      </div>
                    </div>
                    <div class="mb-3 col-md-6">
                      <label class="form-label" for="password">Password baru</label>
                      <div class="input-group input-group-merge">
                        <!-- <span class="input-group-text">(+62)</span> -->
                        <input type="text" id="password" name="password" class="form-control" />
                      </div>
                    </div>
                    <div class="mb-3 col-md-6">

                      <div class="mb-3 col-md-6">
                        <label class="form-label" for="country">Instalasi</label>
                        <select id="id_unit" name="id_unit" class="select2 form-select">
                          <option value="">Pilih Instalasi</option>
                          <?php foreach ($data_instalasi as $data) {
                            $selected = ($data['id'] == $profile['id_unit']) ? 'selected' : '';
                          ?>
                            <option value="<?= $data['id'] ?>" <?= $selected ?>><?= $data['instalasi'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                    </div>
                    <div class="mt-2">
                      <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                      <a href="../dashboard/index.php" type="reset" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                    </form>
                  </div>
                  <!-- /Account -->
                </div>
              </div>
            </div>
          </div>
          <!-- / Content -->

          <!-- Footer -->
          <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
              <!-- <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
              </div> -->
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
  <script src="../../../assets/js/pages-account-settings-account.js"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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


  <!-- Delete alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>