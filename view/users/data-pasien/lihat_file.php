<?php
session_start();

if (isset($_SESSION['file'])) {
    $file_path = '../../../controller/' . $_SESSION['file']; // Path relatif ke file
    error_log("File path: " . realpath($file_path)); // Debugging

    if (file_exists($file_path)) {
        // Menentukan tipe file
        $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        $mime_type = mime_content_type($file_path);

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lihat File</title>
            <style>
                html,
                body {
                    margin: 0;
                    padding: 0;
                    height: 100%;
                    width: 100%;
                    overflow: hidden; /* Membatasi overflow untuk memblokir scroll */
                    background-color: #f0f0f0;
                }

                /* PDF atau file lainnya akan tetap bisa di-scroll */
                iframe {
                    height: 100%;
                    width: 100%;
                    border: none;
                }

                .disable-select {
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                }

                .disable-context-menu {
                    -webkit-touch-callout: none;
                    -webkit-user-select: none;
                    -khtml-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                }
            </style>
        </head>

        <body class="disable-select disable-context-menu">
            <?php
            // Tampilkan file berdasarkan tipenya
            switch ($file_extension) {
                case 'pdf':
                    // Gunakan object atau iframe untuk menampilkan PDF secara lokal
                    echo '<iframe src="' . htmlspecialchars($file_path) . '#toolbar=0" width="100%" height="100%"></iframe>';
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    echo '<img src="' . htmlspecialchars($file_path) . '" alt="Gambar" width="100%" height="auto">';
                    break;
                case 'mp4':
                case 'webm':
                case 'ogg':
                    echo '<video controls><source src="' . htmlspecialchars($file_path) . '" type="' . htmlspecialchars($mime_type) . '">Browser Anda tidak mendukung tag video.</video>';
                    break;
                case 'doc':
                case 'docx':
                    echo '<p>Untuk melihat file Word, <a href="' . htmlspecialchars($file_path) . '" download>klik di sini untuk mengunduh file.</a></p>';
                    break;
                default:
                    echo '<p>Tipe file tidak didukung untuk pratinjau. <a href="' . htmlspecialchars($file_path) . '" download>Klik di sini untuk mengunduh file.</a></p>';
                    break;
            }
            ?>
        </body>
        <script>
            // Mencegah klik kanan untuk menonaktifkan menu konteks
            document.addEventListener('contextmenu', event => event.preventDefault());

            // Mencegah pencetakan halaman
            document.addEventListener('keydown', function(event) {
                if ((event.ctrlKey && event.key === 'p') || event.keyCode === 44) {
                    event.preventDefault();
                }
            });

            // Mencegah screenshot dengan menonaktifkan tombol print screen
            document.addEventListener('keyup', function(event) {
                if (event.key === 'PrintScreen') {
                    navigator.clipboard.writeText('');
                    alert('Screenshots are disabled on this page.');
                }
            });

            // Hitungan mundur 5 menit, kemudian alihkan ke halaman index.php
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 300000);
        </script>

        </html>
<?php
    } else {
        error_log("File tidak ditemukan: " . realpath($file_path)); // Debugging
        $_SESSION['error'] = 'File tidak ditemukan.';
        header("Location: index.php");
        exit();
    }
} else {
    error_log("Parameter file tidak ada."); // Debugging
    $_SESSION['error'] = 'Parameter file tidak ada.';
    header("Location: index.php");
    exit();
}
?>
