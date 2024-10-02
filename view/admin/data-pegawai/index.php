<?php
session_start();
if (!isset($_SESSION['email'])) {
  header('Location: ../../auth/login.php');
  exit();
}
if (($_SESSION['role'] != 'admin')) {
  header('Location: ../../admin/dashboard/index.php');
  # code...
}
require '../../../koneksi.php'; // Menyertakan file koneksi dari folder luar
require '../../../controller/Pegawai.php';

$pegawai = new Pegawai();
$data_pegawai = $pegawai->index();
$profile = $pegawai->profile();
// var_dump($data_pegawai);
$data_instalasi = $pegawai->instalasi();



// if ($_SERVER['REQUEST_METHOD'] == 'POST') :
//   $action = $_POST['action'];
//   if ($action == 'delete') {
//     $id = htmlspecialchars($_POST['id']);
//     // var_dump($id);
//     // $pegawai->delete($id);
//   }
// endif;
// // var_dump($data_pegawai);
?>
<!DOCTYPE html>


<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Data Pegawai</title>

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
          <div class="d-flex flex-column">
            <span class="app-brand-text demo menu-text fw-bolder text-capitalize">DiRec</span>
            <span class="app-brand-text demo menu-text fw-bolder text-capitalize fs-6">Digital Records</span>
          </div>
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
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table /</span>Pegawai</h4>

            <!-- Table Data Pasien -->
            <div class="card shadow mb-3">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Pegawai</th>
                        <th class="text-center">NIP</th>
                        <th class="text-center">Peranan/Jabatan</th>
                        <th class="text-center">Instalasi</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Pegawai</th>
                        <th class="text-center">NIP</th>
                        <th class="text-center">Peranan/Jabatan</th>
                        <th class="text-center">Instalasi</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data_pegawai as $pegawai) { ?>
                        <tr>
                          <td class="text-center"><?= $no++; ?>
                            <!--  -->
                          </td>
                          <td class="text-center"><?= $pegawai['Nama'] ?></td>
                          <td class="text-center"><?= $pegawai['nip'] ?></td>
                          <td class="text-center"><?= $pegawai['role'] ?></td>
                          <td class="text-center"><?= $pegawai['instalasi'] ?></td>
                          <td class="text-center">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#showModal" onclick="detail(<?= htmlspecialchars(json_encode($pegawai), ENT_QUOTES, 'UTF-8'); ?>)">
                              <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#editModal" onclick="edit(<?= htmlspecialchars(json_encode($pegawai), ENT_QUOTES, 'UTF-8'); ?>)">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button id="deleteButton" class="btn btn-danger" onclick="deleteData(<?= htmlspecialchars(json_encode($pegawai), ENT_QUOTES, 'UTF-8');  ?>)">
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


            <!-- Modal Edit data pegawai -->
            <div class="modal fade" id="editModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Edit Data Pegawai</h4>
                    <a data-dismiss="modal">
                      <i class="bi bi-x"></i>
                    </a>
                  </div>

                  <!-- Modal Body -->
                  <div class="modal-body">
                    <form action="../../../controller/Auth.php" method="POST">
                      <div class="container">
                        <div class="row">
                          <div class="form-group">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" id="id_edit">
                            <label for="name">Nama Pegawai <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name_edit" name="name" placeholder="Masukan Nama Lengkap" required>
                          </div>
                          <div class="form-group">
                            <label for="nip">NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nip_edit" name="nip" placeholder="Masukan NIP" required>
                          </div>
                          <div class="form-group">
                            <label for="no_tlp">No. Telp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="no_tlp_edit" name="no_tlp" placeholder="Masukan No. Telp" required>
                          </div>
                          <div class="form-group">
                            <label for="role_edit">Peranan/Jabatan <span class="text-danger">*</span></label>
                            <select name="role" class="form-control" id="role_edit" placeholder="Pilih Instalasi" required>
                              <option value="">Pilih Jabatan</option>
                              <option value="Dokter">Dokter</option>
                              <option value="Perawat">Perawat</option>
                              <!-- > -->
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="instalasi_edit">Instalasi <span class="text-danger">*</span></label>
                            <select name="id_unit" class="form-control" id="instalasi_edit" placeholder="Pilih Instalasi" required>
                              <option value="">Pilih Unit/Instalasi</option>
                              <?php foreach ($data_instalasi as $data) { ?>
                                <option value="<?= $data['id'] ?>"><?= $data['instalasi'] ?></option>
                              <?php } ?>

                            </select>
                          </div>
                        </div>
                      </div>

                  </div>

                  <!-- Modal Footer -->
                  <div class=" modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                  </div>
                  </form>
                  <!-- <button type="submit">Simpan</button> -->
                  <!-- </form> -->
                </div>
              </div>
            </div>

            <!-- Modal show data pegawai-->
            <div class="modal fade" id="showModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Detail Data Pegawai</h4>
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
                              <img src="../../../assets/images/profile/picture.jpeg" alt="user-avatar" class="d-block rounded" height="300" width="300" id="uploadedAvatar">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">Nama Pegawai <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="nama_detail" name="Nama" placeholder="Masukan Nama Lengkap" readonly>
                            </div>
                            <div class="form-group">
                              <label for="nip">NIP <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="nip_detail" name="nip" placeholder="Masukan NIP" readonly>
                            </div>
                            <div class="form-group">
                              <label for="no_tlp">No. Telp <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="no_tlp_detail" name="no_tlp" placeholder="Masukan No. Telp" readonly>
                            </div>
                            <div class="form-group">
                              <label for="jabatan">Peranan/Jabatan <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="jabatan_detail" name="jabatan" placeholder="Masukan Jabatan/Peranan" readonly>
                            </div>
                            <div class="form-group">
                              <label for="instalasi">Instalasi <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="instalasi_detail" name="instalasi" placeholder="Masukan Instalasi" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>

                  <!-- Modal Footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <!-- / Content -->
          <form action="<?= $_SERVER['PHP_SELF']; ?>?page=data-pegawai" id="formDelete" method="POST">
            <input type="hidden" name="id" id="idDelete">
            <input type="hidden" name="action" value="delete">
          </form>
          <!-- Footer -->
          <footer class="content-footer footer bg-footer-theme">
            <!-- <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
              <div class="mb-2 mb-md-0">
                ©
                <script>
                  document.write(new Date().getFullYear());
                </script>
              </div>
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

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <!-- Page level plugins -->
  <script src="../../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../../../assets/js/demo/datatables-demo.js"></script>

  <!-- modal -->

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <!-- logout script -->
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

  <!-- Delete alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function deleteData(data) {
      console.log(data);
      const userId = data.id_user;
      console.log(userId);
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
          window.location.href = '../../../controller/hapus_pegawai.php?action=delete&id=' + userId;
          // window.location.href = 'index.php?action=delete&id=' 
        }
      });
    }
  </script>

  <!-- modal edit -->
  <script>
    // Handle form submission
    // document.getElementById('editForm').addEventListener('submit', function(event) {
    //   event.preventDefault();
    //   // Perform your insert operation here, e.g., send data to the server
    //   alert('Form submitted!');
    //   // Close the modal
    //   $('#editModal').modal('hide');
    // });



    function detail(data) {
      // console.log(data.id_user)
      document.getElementById('nama_detail').value = data.Nama
      document.getElementById('nip_detail').value = data.nip
      document.getElementById('no_tlp_detail').value = data.no_telfon

      document.getElementById('jabatan_detail').value = data.role
      document.getElementById('instalasi_detail').value = data.instalasi



      let imagePath;

      if (data.gambar === 'profile.jpg') {
        imagePath = "../../../assets/images/profile/picture.jpeg";
      } else {
        const basePath = '../../../controller/uploads/profile/';
        imagePath = basePath + data.gambar;
      }

      // Mengubah gambar sesuai dengan path yang telah digabungkan
      document.getElementById('uploadedAvatar').src = imagePath;


    }




    // function detail(data) {
    //   console.log(data)
    //   document.getElementById('nama_detail').value = data.Nama
    //   document.getElementById('nip_detail').value = data.nip
    //   document.getElementById('no_tlp_detail').value = data.no_telfon

    //   document.getElementById('jabatan_detail').value = data.role
    //   document.getElementById('instalasi_edit').value = data.instalasi


    // }
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

    function edit(data) {

      document.getElementById('id_edit').value = data.id_user
      document.getElementById('name_edit').value = data.Nama
      document.getElementById('nip_edit').value = data.nip
      document.getElementById('no_tlp_edit').value = data.no_telfon

      document.getElementById('role_edit').value = data.role
      document.getElementById('instalasi_edit').value = data.id_unit
    }
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
  </script>



</body>

</html>