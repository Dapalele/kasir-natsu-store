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

// Ambil data dari form
$namaProduk = $_POST['namaProduk'];
$hargaBaru = floatval($_POST['harga']);
$tambahStok = intval($_POST['stok']);

// Ambil stok lama dari database
$sql = "SELECT Stok FROM Produk WHERE NamaProduk = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $namaProduk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stokLama = intval($row['Stok']);
    $stokBaru = $stokLama + $tambahStok;

    // Update harga dan stok
    $updateSql = "UPDATE Produk SET Harga = ?, Stok = ? WHERE NamaProduk = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("dis", $hargaBaru, $stokBaru, $namaProduk);

    if ($updateStmt->execute()) {
        // Tampilkan pesan sukses langsung
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Produk Diperbarui</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #f8f9fa;
                    padding: 40px;
                    font-family: 'Segoe UI', Arial, sans-serif;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 30px;
                    background: white;
                    border-radius: 10px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                    text-align: center;
                }
                h1 {
                    color: #2c3e50;
                    margin-bottom: 20px;
                }
                .btn {
                    margin-top: 15px;
                    width: 100%;
                    padding: 12px;
                    font-weight: bold;
                    border-radius: 8px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Produk Berhasil Diperbarui!</h1>
                <p><strong><?= htmlspecialchars($namaProduk) ?></strong> sekarang memiliki harga <strong>Rp <?= number_format($hargaBaru, 2, ',', '.') ?></strong> dan total stok <strong><?= $stokBaru ?></strong>.</p>

                <a href="update_produk.php" class="btn btn-secondary">Update Produk Lain</a>
                <a href="index.php" class="btn btn-success">Kembali ke Dashboard</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Gagal update produk: " . $conn->error;
    }

} else {
    echo "Produk tidak ditemukan.";
}

$conn->close();
?>
