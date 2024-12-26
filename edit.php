<?php
include 'koneksi.php';

// Validasi apakah parameter 'id' ada di URL
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID tidak valid! Pastikan URL berisi parameter id, misalnya: edit.php?id=1");
}

// Query untuk mengambil data berdasarkan id
$query = "SELECT * FROM transaksi WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan");
}

// Sertakan file tampilan form
include 'yayah.php';
?>
