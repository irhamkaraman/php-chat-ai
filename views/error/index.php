<?php 
require 'env.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Tidak Ditemukan</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/blob.css">
</head>
<body>
  <div class="blob blob1"></div>
  <div class="blob blob2"></div>
  <div class="blob blob3"></div>
  <div class="container">
    <h2>Oops, Halaman Tidak Ditemukan</h2>
    <a href="<?= $currentUrl; ?>/"><button>Kembali ke halaman utama</button></a>
  </div>
</body>
</html>