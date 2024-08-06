<?php
session_start();
if (isset($_GET['file'])) {
    $file_path = '../../' . $_GET['file']; // Path relatif ke file PDF
    error_log("File path: " . realpath($file_path)); // Debugging
    if (file_exists($file_path)) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lihat File</title>
            <script>
                // Hitungan mundur 3 detik, kemudian alihkan ke halaman index.php
                setTimeout(function(){
                    window.location.href = 'index.php';
                }, 3000);
            </script>
        </head>
        <body>
            <embed src="<?php echo htmlspecialchars($file_path); ?>" type="application/pdf" width="100%" height="100%">
        </body>
        </html>
        <?php
    } else {
        error_log("File not found: " . realpath($file_path)); // Debugging
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
