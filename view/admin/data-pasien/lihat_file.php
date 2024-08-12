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
                html, body {
                    margin: 0;
                    padding: 0;
                    height: 100%;
                    width: 100%;
                    overflow: hidden; /* Hilangkan scrollbar */
                    background-color: #f0f0f0;
                }
                embed, img, video, iframe {
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
                .overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 999;
                    background: rgba(255, 255, 255, 0); /* Transparan */
                }
            </style>
        </head>
        <body class="disable-select disable-context-menu">
            <div class="overlay"></div>
            <?php
            // Tampilkan file berdasarkan tipenya
            switch ($file_extension) {
                case 'pdf':
                    echo '<iframe src="' . htmlspecialchars($file_path) . '" type="application/pdf"></iframe>';
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    echo '<img src="' . htmlspecialchars($file_path) . '" alt="Gambar">';
                    break;
                case 'mp4':
                case 'webm':
                case 'ogg':
                    echo '<video controls><source src="' . htmlspecialchars($file_path) . '" type="' . htmlspecialchars($mime_type) . '">Browser Anda tidak mendukung tag video.</video>';
                    break;
                case 'doc':
                case 'docx':
                    $file_path_encoded = urlencode($file_path);
                    echo '<iframe src="https://docs.google.com/gview?url=' . htmlspecialchars($file_path_encoded) . '&embedded=true" allowfullscreen></iframe>';
                    break;
                default:
                    echo '<p>Tipe file tidak didukung untuk pratinjau. <a href="' . htmlspecialchars($file_path) . '" download>Klik di sini untuk mengunduh file.</a></p>';
                    break;
            }
            ?>
        </body>
        <script>
            // Hitungan mundur 5 menit, kemudian alihkan ke halaman index.php
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 300000); // 300.000 milidetik = 5 menit
            
            // Mencegah klik kanan untuk menonaktifkan menu konteks
            document.addEventListener('contextmenu', event => event.preventDefault());
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
