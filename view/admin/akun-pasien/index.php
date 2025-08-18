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


?>

<!DOCTYPE html>


<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Data Pasien</title>

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
          <li class="menu-item active">
            <a href="../akun-pasien/index.php" class="menu-link">
              <i class="menu-icon bi-person "></i>
              <div data-i18n="Account Settings">Akun Pasien</div>
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
          <li class="menu-item">
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

                    <img src="../../../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />

                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="../../../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />

                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block">Asep</span>
                          <!-- sesuai role -->
                          <small class="text-muted">Admin</small>
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
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table /</span>Akun Pasien</h4>

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
                        <th class="text-center">NIK</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">No Telp</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">NIK</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">No Telp</th>
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
                        <td class="text-center">
                          <button class="btn btn-primary" data-toggle="modal" data-target="#showModal" onclick="">
                            <i class="bi bi-eye"></i>
                          </button>
                          <button class="btn btn-warning" data-toggle="modal" data-target="#editModal" onclick="">
                            <i class="bi bi-pencil"></i>
                          </button>
                          <button id="deleteButton" class="btn btn-danger" onclick="">
                            <i class="bi bi-trash"></i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!--/ Responsive Table -->


            <!-- Modal Insert data pasien-->
            <div class="modal fade" id="insertModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Tambah Akun Pasien</h4>
                    <a data-dismiss="modal">
                      <i class="bi bi-x"></i>
                    </a>
                  </div>

                  <!-- Modal Body -->
                  <div class="modal-body">
                    <form id="insertForm" action="../../../controller/Pasien.php" method="POST" enctype="multipart/form-data">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-6 c">
                            <!-- Input Nama Lengkap -->
                            <div class="form-group">
                              <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Lengkap" required>
                            </div>

                            <!-- Input Email -->
                            <div class="form-group">
                              <label for="email">Email <span class="text-danger">*</span></label>
                              <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
                            </div>

                            <!-- Input No Telpon -->
                            <div class="form-group">
                              <label for="no_telfon">No. Telpon <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="no_telfon" name="no_telfon" placeholder="Masukkan No Telpon" required>
                            </div>
                          </div>

                          <div class="col-md-6 c">
                            <!-- Input Password -->
                            <div class="form-group">
                              <label for="password">Password <span class="text-danger">*</span></label>
                              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                            </div>

                            <!-- Input Role -->
                            <div class="form-group">
                              <label for="role">Role <span class="text-danger">*</span></label>
                              <select class="form-control" id="role" name="role" required>
                                <option value="patient">Pasien</option>
                                <!-- Tambahkan role lain jika diperlukan -->
                              </select>
                            </div>

                            <!-- Input NIP -->
                            <div class="form-group">
                              <label for="nip">NIP</label>
                              <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP">
                            </div>

                            <!-- Input ID Unit -->
                            <input type="hidden" name="id_unit" value="NULL">

                            <input type="hidden" name="gambar" value="picture.jpeg">
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
                  <form id="insertForm" action="#" method="POST" enctype="multipart/form-data">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-6 c">
                          <div class="form-group">
                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Lengkap" required>
                          </div>
                          <div class="form-group">
                            <label for="name">Email<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Lengkap" required>
                          </div>
                          <div class="form-group">
                            <label for="name">No Telpon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Lengkap" required>
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
                    <form id="insertForm" action="#" method="POST" enctype="multipart/form-data">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-6 c">
                            <div class="form-group">
                              <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Lengkap" required>
                            </div>
                            <div class="form-group">
                              <label for="name">Email<span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Lengkap" required>
                            </div>
                            <div class="form-group">
                              <label for="name">No Telpon <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Lengkap" required>
                            </div>
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
        <form action="../../../controller/Pasien.php" id="formDelete" method="POST">
          <input type="hidden" name="id_pasien" id="idDelete">
          <input type="hidden" name="action" value="delete">
        </form>
        <!-- Footer -->
        <footer class="content-footer footer bg-footer-theme">
          <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
              <!-- <script>
              document.write(new Date().getFullYear());
            </script> -->
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