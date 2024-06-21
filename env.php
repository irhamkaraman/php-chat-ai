<?php 
$currentUrl = "/praktikumpemweb/pertemuan_6";
$groq_api = "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";

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "irham_23533740";

$koneksi = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}