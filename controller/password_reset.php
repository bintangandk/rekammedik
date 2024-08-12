<?php
session_start();

include '../koneksi.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
date_default_timezone_set('Asia/Jakarta');
// include '../vendor/phpmailer/phpmailer/src/Exception.php';
// include '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
// include '../vendor/phpmailer/phpmailer/src/SMTP.php';
$con= new koneksi();
$email=$_POST["email"];
$token = random_int(100000, 999999); // Menghasilkan token berupa angka acak 6 digit

$expiry=date("Y-m-d H:i:s", time()+60*30);

$cek="SELECT * FROM users where email='$email'";
$existingData = $con->execute($cek);
if ($existingData->num_rows == 0) {
    
    $_SESSION['error'] = 'Email Tidak terdata';
    header("Location: ../view/auth/forgot-password.php");
}

$query="UPDATE users SET reset_token_hash='$token', reset_token_expires_at='$expiry' where email='$email'";
$con->execute($query);


$email_pengirim="rekammedik700@gmail.com";
$nama_pengirim="SiRekam";
$email_penerima=$email;
$subjek="Lupa Password";
$pesan="token yang harus anda masukkan ialah  ".$token;


$mail=new PHPMailer(true);
try {
$mail->isSMTP();
$mail->SMTPAuth=true;
$mail->Host="smtp.gmail.com";
$mail->SMTPSecure='tls';
// $mail->Port=587;
$mail->Username=$email_pengirim;
$mail->Password="prkv yzou wskp zolg";
$mail->Port=587;
$mail->SMTPDebug=2;
$mail->setFrom($email_pengirim,$nama_pengirim);
$mail->addAddress($email_penerima);
$mail->isHTML(true);
$mail->Subject=$subjek;
$mail->Body=$pesan;
$send=$mail->send();

// if ($send) {
    $_SESSION["email1"]=$email;
    $_SESSION["success"]="Berhasil Kirim kode di email anda , silahkan isi kode sesuai dengan yang dikirim di email anda";
    header("Location: ../view/auth/token.php");
    exit();
} catch (Exception $e) {
// }else {
    $_SESSION['error'] = 'Email gagal di kirim';
    header("Location: ../view/auth/forgot-password.php");
}
  // header("Location: ../view/auth/forgot-password.php");
// }
// $email->SMTPAuth=true;



 
