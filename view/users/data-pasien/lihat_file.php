<?php
session_start();
if (isset($_SESSION['file'])) {
    $file_path = '../../../controller/' . $_SESSION['file']; // Path relatif ke file PDF
    error_log("File path: " . realpath($file_path)); // Debugging
    if (file_exists($file_path)) {
// ?>
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
                }
                embed {
                    height: 100%;
                    width: 100%;
                    border: none;
                }
            </style>
        </head>

        <body>
            <!-- <?php var_dump($file_path); ?> -->
            <embed src="<?php echo htmlspecialchars($file_path); ?>" type="application/pdf">
        </body>
        <script>
    // Hitungan mundur 5 menit, kemudian alihkan ke halaman index.php
    setTimeout(function() {
        window.location.href = 'index.php';
    }, 300000); // 300.000 milidetik = 5 menit
</script>

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
