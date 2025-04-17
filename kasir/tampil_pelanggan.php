<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Handle penghapusan
if (isset($_GET['hapus'])) {
    $idToDelete = intval($_GET['hapus']);

    // Ambil semua PenjualanID milik pelanggan ini
    $resultPenjualan = $conn->query("SELECT PenjualanID FROM Penjualan WHERE PelangganID = $idToDelete");
    if ($resultPenjualan->num_rows > 0) {
        while ($penjualan = $resultPenjualan->fetch_assoc()) {
            $penjualanID = $penjualan['PenjualanID'];
            // Hapus detail penjualan terkait
            $conn->query("DELETE FROM DetailPenjualan WHERE PenjualanID = $penjualanID");
        }
    }

    // Hapus penjualan
    $conn->query("DELETE FROM Penjualan WHERE PelangganID = $idToDelete");

    // Hapus pelanggan
    $conn->query("DELETE FROM Pelanggan WHERE PelangganID = $idToDelete");

    // Redirect setelah hapus
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #fff;
        color: #111;
        margin: 20px 0;
    }

    h1 {
        text-align: center;
        margin-bottom: 40px;
        font-weight: 600;
        color: #000;
    }

    .search-form {
        max-width: 600px;
        margin: 0 auto 30px auto;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #aaa;
    }

    .btn-primary {
        background-color: #000;
        border: none;
    }

    .btn-primary:hover {
        background-color: #222;
    }

    .table-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }

    table th {
        background-color: #f5f5f5;
        font-weight: 600;
    }

    table tr:hover {
        background-color: #f9f9f9;
    }

    .btn-delete {
        background-color: #000;
        color: #fff;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 14px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #333;
    }

    .btn-back {
        display: block;
        width: 220px;
        margin: 40px auto 0;
        text-align: center;
        padding: 12px;
        background-color: #000;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-back:hover {
        background-color: #222;
    }
</style>

</head>
<body>

    <div class="container">
        <h1>Daftar Pelanggan</h1>

        <!-- Form Pencarian -->
        <form method="get" class="search-form">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" placeholder="Cari nama pelanggan..." value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <!-- Tabel Pelanggan -->
        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>Nomor Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cari = isset($_GET['cari']) ? $conn->real_escape_string($_GET['cari']) : '';
                    if (!empty($cari)) {
                        $sql = "SELECT PelangganID, NamaPelanggan, Alamat, NomorTelepon FROM Pelanggan WHERE NamaPelanggan LIKE '%$cari%'";
                    } else {
                        $sql = "SELECT PelangganID, NamaPelanggan, Alamat, NomorTelepon FROM Pelanggan";
                    }
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $no = 1;
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $no++ . "</td>
                                    <td>" . htmlspecialchars($row["NamaPelanggan"]) . "</td>
                                    <td>" . htmlspecialchars($row["Alamat"]) . "</td>
                                    <td>" . htmlspecialchars($row["NomorTelepon"]) . "</td>
                                    <td>
                                        <a href='?hapus=" . $row["PelangganID"] . "' class='btn-delete' onclick='return confirm(\"Yakin ingin menghapus pelanggan ini?\")'>Hapus</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Tidak ada data pelanggan.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <a href="index.php" class="btn-back">Kembali ke Halaman Utama</a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
