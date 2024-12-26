<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran</title>
    <style>
        /* Reset dan Umum */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        form {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 500px;
        }

        form h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #5f6368;
        }

        form h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #5f6368;
        }

        input[type="text"], input[type="password"], input[type="number"] {
            width: calc(100% - 24px);
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 14px;
            transition: border-color 0.3s;
            background: #f9f9f9;
        }

        input[type="text"]:focus, input[type="password"]:focus, input[type="number"]:focus {
            border-color: #ff758c;
            outline: none;
            background: #fff;
        }

        input.error {
            border-color: red;
            background-color: #ffe6e6;
        }

        .barang-list div {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .barang-list label {
            margin-left: 10px;
            font-size: 14px;
            flex: 1;
        }

        .barang-list input[type="number"] {
            max-width: 80px;
            margin-left: 10px;
        }

        input[type="submit"] {
            background: linear-gradient(to right, #ff758c, #ff7eb3);
            color: #fff;
            padding: 12px 15px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
        }

        input[type="submit"]:hover {
            background: linear-gradient(to right, #ff5a7e, #ff6ca8);
        }

        @media (max-width: 768px) {
            form {
                padding: 30px;
            }

            input[type="text"], input[type="password"], input[type="number"] {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

<form action="submit2.php" method="post" onsubmit="return validateForm()">
    <h1>Formulir Pendaftaran</h1>

    <!-- Input Data -->
    <input type="hidden" name="id" value="<?php if (!empty($data['id'])) { echo htmlspecialchars($data['id']); } ?>">
    <input type="text" name="username" placeholder="Username" required value="<?php if (!empty($data['Username'])) { echo htmlspecialchars($data['Username']); } ?>">
    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required value="<?php if (!empty($data['Nama Lengkap'])) { echo htmlspecialchars($data['Nama Lengkap']); } ?>">
    <input type="text" name="email" placeholder="Email" required value="<?php if (!empty($data['email'])) { echo htmlspecialchars($data['email']); } ?>">
    <input type="password" id="password" name="password" placeholder="Password (minimal 6 karakter)" required>

    <?php
        // Decode data barang terpilih
        $data_barang_terpilih = (!empty($data['data_barang'])) ? json_decode($data['data_barang'], true) : array();
    ?>

    <!-- Pilihan Barang -->
    <h3>Pilih Barang:</h3>
    <div class="barang-list">
        <div>
            <input type="checkbox" name="barang[]" value="tas - Rp230.000" id="tas" <?php echo in_array("tas - Rp230.000", $data_barang_terpilih) ? 'checked' : ''; ?>>
            <label for="tas">Tas - Rp230.000</label>
            <input type="number" name="jumlah[]" placeholder="Jumlah" min="1" disabled>
        </div>
        <div>
            <input type="checkbox" name="barang[]" value="kerudung - Rp50.000" id="kerudung" <?php echo in_array("kerudung - Rp50.000", $data_barang_terpilih) ? 'checked' : ''; ?>>
            <label for="kerudung">Kerudung - Rp50.000</label>
            <input type="number" name="jumlah[]" placeholder="Jumlah" min="1" disabled>
        </div>
        <div>
            <input type="checkbox" name="barang[]" value="jam - Rp70.000" id="jam" <?php echo in_array("jam - Rp70.000", $data_barang_terpilih) ? 'checked' : ''; ?>>
            <label for="jam">Jam - Rp70.000</label>
            <input type="number" name="jumlah[]" placeholder="Jumlah" min="1" disabled>
        </div>
    </div>

    <!-- Submit Button -->
    <input type="submit" value="submit">
</form>

<script>
    function validateForm() {
        var password = document.getElementById("password");
        if (password.value.length < 6) {
            alert("Password harus memiliki minimal 6 karakter");
            password.classList.add("error");
            password.focus();
            return false;
        } else {
            password.classList.remove("error");
        }
        return true;
    }

    // Enable jumlah input only if checkbox is checked
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox, index) {
        checkbox.addEventListener('change', function() {
            const jumlahInput = document.querySelectorAll('input[type="number"]')[index];
            jumlahInput.disabled = !this.checked;
            if (!this.checked) jumlahInput.value = '';
        });
    });
</script>

</body>
</html> 