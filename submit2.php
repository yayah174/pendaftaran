<?php
// Memeriksa apakah data telah disubmit
if (isset($_POST['username'])) {
    // Mengambil data dari formulir dengan validasi
    $uname = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
    $nmlengkap = isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
    $diskon = isset($_POST['diskon']) ? htmlspecialchars($_POST['diskon']) : 0;

    // Memproses array barang dan jumlah
    $barang = isset($_POST['barang']) ? $_POST['barang'] : []; // Array produk yang dipilih
    $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : []; // Array jumlah produk

    // Mengubah array barang menjadi format JSON
    $jeksonbarang = json_encode($barang);

    // Menghubungkan ke file koneksi.php
    include 'koneksi.php';

    // Validasi koneksi
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Query untuk menyimpan data
    $sql = "INSERT INTO transaksi (nama, email, nama_lengkap, password, data_barang) 
            VALUES ('$uname', '$email', '$nmlengkap', '$password', '$jeksonbarang')";

    // Menjalankan query
    if (mysqli_query($conn, $sql)) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Menutup koneksi
    mysqli_close($conn);

    // Tampilkan data dalam format invoice
    $tampil = "
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
            padding: 0;
        }
        .invoice {
            width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 24px;
            color: #333;
            margin: 10px 0;
        }
        .separator {
            border-bottom: 2px solid #007bff;
            margin: 20px 0;
        }
        .content {
            font-size: 16px;
            color: #333;
        }
        .content .item {
            margin: 10px 0;
        }
        .products {
            margin-top: 20px;
        }
        .products h3 {
            margin-bottom: 10px;
            color: #007bff;
        }
        .products p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-style: italic;
            color: #555;
        }
    </style>
    <div class='invoice'>
        <div class='header'>
            <img src='logo_toko.png' alt='Logo Toko' class='logo'>
            <h2>INVOICE</h2>
            <div class='separator'></div>
        </div>
        <div class='content'>
            <div class='item'><strong>Username:</strong> $uname</div>
            <div class='item'><strong>Nama Lengkap:</strong> $nmlengkap</div>
            <div class='item'><strong>Email:</strong> $email</div>
            <div class='item'><strong>Password:</strong> $password</div>
            <div class='item'><strong>Diskon:</strong> $diskon%</div>
        </div>
        <div class='products'>
            <h3>Produk yang Dipilih:</h3>";

    if (!empty($barang)) {
        foreach ($barang as $key => $product) {
            $produk_quantity = isset($jumlah[$key]) ? $jumlah[$key] : 0;
            $tampil .= "<p><strong>$product</strong> - Jumlah: $produk_quantity</p>";
        }
    } else {
        $tampil .= "<p>Belum ada produk yang dipilih</p>";
    }

    $tampil .= "
        </div>
        <div class='footer'>Terima kasih atas kepercayaan Anda berbelanja di toko kami!</div>
    </div>";
} else {
    $tampil = "Data tidak disubmit.";
}

echo $tampil;
?>
