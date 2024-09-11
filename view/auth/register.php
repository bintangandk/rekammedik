<?php
session_start();


require '../../koneksi.php';
require '../../controller/Pegawai.php';

$unit = new Pegawai();
$data_unit = $unit->instalasi();
?>

<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Register</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../../../assets/img/favicon/logo-si.png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />
  <!-- Helpers -->
  <script src="../../assets/vendor/js/helpers.js"></script>

  <script src="../../assets/js/config.js"></script>
</head>

<body>
  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register Card -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link">
                <span class="app-brand-logo demo">
                  <img src="../../assets/img/favicon/logo-si.png" alt="Logo" width="80">
                </span>
                <span class="app-brand-text demo menu-text fw-bolder ms-0 text-capitalize" style="margin-left: 0;">DiRec</span>
              </a>
            </div>
            
            <h4 class="mb-2"></h4>

            <form id="formAuthentication" class="mb-3" action="../../controller/Auth.php" method="POST">
              <input type="hidden" name="action" value="register">
              <div class="mb-3">
                <label for="username" class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" name="Nama" placeholder="Masukkan nama anda" value="<?php echo isset($_SESSION['form_data']['Nama']) ? htmlspecialchars($_SESSION['form_data']['Nama']) : ''; ?>" autofocus />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan email anda" value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" />
              </div>
              <div class="mb-3">
                <label for="no_telfon" class="form-label">Nomor Telpon <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="notelp" name="no_telfon" placeholder="Masukkan Nomor telp anda" value="<?php echo isset($_SESSION['form_data']['no_telfon']) ? htmlspecialchars($_SESSION['form_data']['no_telfon']) : ''; ?>" />
              </div>
              <div class="mb-3">
                <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP anda" value="<?php echo isset($_SESSION['form_data']['nip']) ? htmlspecialchars($_SESSION['form_data']['nip']) : ''; ?>" />
              </div>
              <div class="mb-3">
                <label for="role" class="form-label">Jabatan/Peranan <span class="text-danger">*</span></label>
                <select name="role" class="form-control" id="role" required>
                  <option value="">Pilih Jabatan/Peranan</option>
                  <option value="Dokter" <?php echo isset($_SESSION['form_data']['role']) && $_SESSION['form_data']['role'] == 'Dokter' ? 'selected' : ''; ?>>Dokter</option>
                  <option value="Perawat" <?php echo isset($_SESSION['form_data']['role']) && $_SESSION['form_data']['role'] == 'Perawat' ? 'selected' : ''; ?>>Perawat</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="id_unit" class="form-label">Instalasi/Unit <span class="text-danger">*</span></label>
                <select name="id_unit" class="form-control" id="id_unit" required>
                  <option value="">Pilih Jabatan/Peranan</option>
                  <?php foreach ($data_unit as $key => $value) { ?>
                    <option value="<?= $value['id'] ?>" <?php echo isset($_SESSION['form_data']['id_unit']) && $_SESSION['form_data']['id_unit'] == $value['id'] ? 'selected' : ''; ?>>
                      <?= $value['instalasi']; ?>
                    </option>
                  <?php } ?>

                </select>
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>

              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Register</button>
              </div>
            </form>

            <p class="text-center">
              <span>Sudah punya akun?</span>
              <a href="login.php">
                <span>Login disini</span>
              </a>
            </p>
          </div>
        </div>
        <!-- Register Card -->
      </div>
    </div>
  </div>

  <!-- / Content -->

  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ambil pesan error dari sesi
      const errors = <?php echo json_encode(isset($_SESSION['errors']) ? $_SESSION['errors'] : []); ?>;
      // Ambil pesan sukses dari sesi
      const success = <?php echo json_encode(isset($_SESSION['success']) ? $_SESSION['success'] : ''); ?>;

      // Jika ada pesan error, tampilkan notifikasi error
      if (errors.length > 0) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          html: errors.join('<br>'),
          confirmButtonText: 'OK'
        }).then(() => {
          // Kosongkan pesan error setelah ditampilkan
          <?php unset($_SESSION['errors']); ?>
        });
      }

      // Jika ada pesan sukses, tampilkan notifikasi sukses
      if (success) {
        Swal.fire({
          icon: 'success',
          title: 'Sukses',
          text: success,
          confirmButtonText: 'OK'
        }).then(() => {
          // Kosongkan pesan sukses setelah ditampilkan
          <?php unset($_SESSION['success']); ?>
        });
      }
    });
  </script>

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="../../assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="../../assets/js/main.js"></script>

  <!-- Page JS -->

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>