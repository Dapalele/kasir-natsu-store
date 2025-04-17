<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir";
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Handle penghapusan produk
if (isset($_GET['hapus'])) {
    $idToDelete = intval($_GET['hapus']);

    // Hapus terlebih dahulu semua data terkait di detailpenjualan
    $conn->query("DELETE FROM detailpenjualan WHERE ProdukID = $idToDelete");

    // Baru hapus dari tabel produk
    $conn->query("DELETE FROM Produk WHERE ProdukID = $idToDelete");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #ffffff;
        color: #111;
        margin: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 40px;
        font-weight: 600;
    }

    table {
        width: 90%;
        margin: 0 auto;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-radius: 10px;
        overflow: hidden;
    }

    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    th {
        background-color: #f9f9f9;
        font-weight: 600;
    }

    tr:hover {
        background-color: #f6f6f6;
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

    .btn-warning {
        background-color: transparent;
        border: 1px solid #000;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #000;
        color: #fff;
    }

    .btn-success, .btn-secondary, .btn-primary {
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-success {
        background-color: #000;
        border: none;
    }

    .btn-success:hover {
        background-color: #222;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #aaa;
    }
</style>

</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<body>
    <h1>Daftar Produk</h1>
    <!-- Form Pencarian -->
<div class="container mb-4 mt-3">
    <form method="GET" class="row g-3 justify-content-center">
        <div class="col-md-4">
            <input type="text" name="cari" class="form-control" placeholder="Cari Nama Produk..." value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="tampil_produk.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>

    
</form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query ambil data produk (dengan ProdukID)
            $cari = isset($_GET['cari']) ? $conn->real_escape_string($_GET['cari']) : '';
            $sql = "SELECT ProdukID, NamaProduk, Harga, Stok FROM Produk";
            
            if (!empty($cari)) {
                $sql .= " WHERE NamaProduk LIKE '%$cari%'";
            }
            
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $no = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $no++ . "</td>
                            <td>" . htmlspecialchars($row["NamaProduk"]) . "</td>
                            <td>Rp " . number_format($row["Harga"], 2, ',', '.') . "</td>
                            <td>" . $row["Stok"] . "</td>
                           <td>
    <a href='update_produk.php?id=" . $row["ProdukID"] . "' class='btn btn-warning btn-sm me-2'>✏️ Edit</a>
    <a href='?hapus=" . $row["ProdukID"] . "' class='btn-delete' onclick='return confirm(\"Yakin ingin menghapus produk ini?\")'>🗑️ Hapus</a>
</td>

                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align: center;'>Tidak ada data produk.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
    <br><br>
    <div class="text-center mt-4">
    <a href="index.php" class="btn btn-success btn-lg">🏠 Kembali ke Halaman Utama</a>
</div>

</body>
</html>
