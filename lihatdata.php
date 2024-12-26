<?php
// Menghubungkan ke file koneksi.php
include 'koneksi.php';

// Query untuk mengambil semua data dari tabel transaksi
$query = "SELECT id, nama, email, data_barang FROM transaksi";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil
if (!$result) {
    die("Terjadi kesalahan saat mengambil data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
            color: #333;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #3a4f63;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #6c5ce7;
            color: #ffffff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f7ff;
            transition: background-color 0.3s ease;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 6px 12px;
            color: white;
            border-radius: 4px;
            margin: 0 5px;
            font-size: 0.9em;
        }

        .action-buttons a.edit {
            background-color: #55efc4;
        }

        .action-buttons a.delete {
            background-color: #ff7675;
        }

        header {
            background-color: #6c5ce7;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        footer {
            background-color: #3a4f63;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<header>
    <h1>Data Transaksi</h1>
</header>

<table>
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Data Barang</th>
        <th>Aksi</th>
    </tr>

    <?php
    // Periksa apakah tabel memiliki data
    if (mysqli_num_rows($result) > 0) {
        // Menampilkan data per baris
        while ($row = mysqli_fetch_assoc($result)) {
            // Decode data_barang jika berbentuk JSON
            $decoded_data = json_decode($row['data_barang'], true);
            $barang_list = $decoded_data ? implode(", ", $decoded_data) : $row['data_barang'];

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($barang_list) . "</td>";
            echo "<td class='action-buttons'>
                    <a class='edit' href='edit.php?id=" . urlencode($row['id']) . "'>Edit</a>
                    <a class='delete' href='delete.php?id=" . urlencode($row['id']) . "'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Tidak ada data ditemukan.</td></tr>";
    }
    ?>
</table>

<footer>
    <p>&copy; 2024 Kasir Sederhana. All rights reserved.</p>
</footer>

<?php
// Menutup koneksi
mysqli_close($conn);
?>

</body>
</html>
