<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['role'])) {
  header("Location: ../admin/dashboard/index.php"); // Arahkan ke halaman dashboard atau halaman lain sesuai kebutuhan
  exit();
}

?>

<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Login</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/logo-si.png" />

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

  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../../assets/js/config.js"></script>
</head>

<style>
  .app-brand {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .app-brand-logo img {
    margin-right: -15px;
  }

  .app-brand-text {
    margin-left: 0;
    padding-left: 0;
  }
</style>

<body>
  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand d-flex justify-content-center align-items-center">
              <a href="index.html" class="app-brand-link d-flex align-items-center">
                <span class="app-brand-logo demo">
                  <img src="../../assets/img/favicon/logo-si.png" alt="Logo" width="80">
                </span>
                <span class="app-brand-text demo menu-text fw-bolder ms-0 text-capitalize" style="margin-left: 0; padding-left: 0;">DiRec</span>
              </a>
            </div>

            <h4 class="mb-2"></h4>

            <form id="formAuthentication" class="mb-3" action="../../controller/Auth.php" method="POST">
              <div class="mb-3">
                <input type="hidden" name="action" value="login">
                <label for="email" class="form-label">Email atau Username</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Masukan email atau username" autofocus />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3 text-end">
                <a href="forgot-password.php">
                  <small>Lupa Password?</small>
                </a>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
              </div>
            </form>

            <p class="text-center">
              <span>Belum Punya Akun?</span>
              <a href="register.php">
                <span>Register disini</span>
              </a>
            </p>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>

  <!-- / Content -->


  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script>
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
      if (logout) {
        Swal.fire({
          icon: 'success',
          title: 'Sukses',
          text: logout,
        });
        <?php unset($_SESSION['logout']); ?>
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