<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Produk</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --accent:rgb(0, 0, 0);
            --bg-light: #f8f9fa;
            --border-color: #dddddd;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--bg-light);
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: var(--primary);
        }

        form {
            width: 60%;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
        }

        form:hover {
            box-shadow: var(--shadow-hover);
        }

        label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            font-size: 16px;
        }

        input:focus, select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--accent);
            color: white;
            border: none;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color:rgb(179, 179, 179);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            margin-top: 20px;
            padding: 12px;
            background-color: #e2e8f0;
            color: #1e293b;
            text-decoration: none;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-back svg {
            margin-right: 8px;
            width: 20px;
            height: 20px;
        }

        .btn-back:hover {
            background-color: #cbd5e1;
        }
    </style>
</head>
<body>

    <h1>Update Produk</h1>

    <form action="proses_update_produk.php" method="post">
        <label for="namaProduk">Nama Produk:</label>
        <select id="namaProduk" name="namaProduk" required>
            <?php
            // Koneksi ke database
            $servername = "localhost";
            $username = "root"; // Ganti dengan username database Anda
            $password = ""; // Ganti dengan password database Anda
            $dbname = "kasir";

            // Membuat koneksi
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Cek koneksi
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Query untuk mengambil data produk
            $sql = "SELECT NamaProduk, Harga FROM Produk";
            $result = $conn->query($sql);

            // Cek apakah ada data
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["NamaProduk"] . "' data-harga='" . $row["Harga"] . "'>" . $row["NamaProduk"] . " (Rp " . number_format($row["Harga"], 2, ',', '.') . ")</option>";
                }
            } else {
                echo "<option value=''>Tidak ada produk</option>";
            }

            // Menutup koneksi
            $conn->close();
            ?>
        </select>

        <label for="harga">Harga Baru:</label>
        <input type="number" id="harga" name="harga" step="0.01" required>

        <label for="stok">Jumlah Stok yang Ditambahkan:</label>
        <input type="number" id="stok" name="stok" required>

        <button type="submit">Update Produk</button>
        <a href="index.php" class="btn-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
            <path d="M8 16a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm0-14a6 6 0 1 1 0 12 6 6 0 0 1 0-12ZM6.854 8.146a.5.5 0 0 1 0 .708L4.207 10.5H10a.5.5 0 0 1 0 1H4.207l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0Z"/>
        </svg>
        Kembali ke Dashboard
    </a>
    </form>

    <!-- Tombol kembali -->
   

    <script>
        // Menampilkan harga saat produk dipilih
        document.getElementById('namaProduk').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var harga = selectedOption.getAttribute('data-harga');
            document.getElementById('harga').value = harga;
        });
    </script>

</body>
</html>
