<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$pelangganID = $_POST['pelanggan'];
$produkID = $_POST['produk'];
$jumlah = $_POST['jumlah'];

$sql = "SELECT Harga, Stok FROM Produk WHERE ProdukID = $produkID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $harga = $row["Harga"];
    $stok = $row["Stok"];

    if ($stok >= $jumlah) {
        $subtotal = $harga * $jumlah;
        $conn->begin_transaction();

        try {
            $sql = "INSERT INTO Penjualan (TanggalPenjualan, TotalHarga, PelangganID) VALUES (NOW(), $subtotal, $pelangganID)";
            if ($conn->query($sql) === TRUE) {
                $penjualanID = $conn->insert_id;

                $sql = "INSERT INTO DetailPenjualan (PenjualanID, ProdukID, JumlahProduk, Subtotal) VALUES ($penjualanID, $produkID, $jumlah, $subtotal)";
                if ($conn->query($sql) === TRUE) {

                    $sql = "UPDATE Produk SET Stok = Stok - $jumlah WHERE ProdukID = $produkID";
                    if ($conn->query($sql) === TRUE) {
                        $conn->commit();
                        echo "
<div style='
    max-width: 500px;
    margin: 60px auto;
    background-color: #f9f9f9;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    text-align: center;
    font-family: Poppins, sans-serif;
    color: #222;
'>
    <div style='font-size: 60px; color: #27ae60; margin-bottom: 10px;'>✅</div>
    <h2 style='margin-bottom: 15px;'>Penjualan Berhasil!</h2>
    <p style='font-size: 16px; margin-bottom: 30px;'>Data transaksi telah disimpan dengan sukses.</p>
    <a href='penjualan.php' class='btn-kembali'>🔁 Form Baru</a>
    <a href='index.php' class='btn-kembali' style='margin-left: 10px;'>🏠 Beranda</a>
</div>
";

                    } else {
                        throw new Exception("Error mengurangi stok: " . $conn->error);
                    }
                } else {
                    throw new Exception("Error menyimpan detail penjualan: " . $conn->error);
                }
            } else {
                throw new Exception("Error menyimpan penjualan: " . $conn->error);
            }
        } catch (Exception $e) {
            $conn->rollback();
            echo "<div style='color: red; text-align: center; margin-top: 40px;'>
                    <h3>Terjadi kesalahan!</h3>
                    <p>" . $e->getMessage() . "</p>
                    <a href='penjualan.php' class='btn-kembali'>Kembali ke Form Penjualan</a>
                  </div>";
        }
    } else {
        echo "
        <div style='max-width:500px; margin:50px auto; padding:20px; border:1px solid red; background-color:#ffe6e6; color:#cc0000; border-radius:8px; text-align:center;'>
            <h3>⚠️ Stok Tidak Mencukupi</h3>
            <p>Stok yang tersedia hanya <strong>$stok</strong> unit.</p>
            <a href='penjualan.php' class='btn-kembali'>Kembali ke Form Penjualan</a>
        </div>
        ";
    }
} else {
    echo "<p>Produk tidak ditemukan.</p>";
}

$conn->close();
?>

<!-- Tambahkan CSS untuk styling tombol "Kembali" yang lebih profesional -->
<style>
    .btn-kembali {
        padding: 12px 25px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 30px;
        text-decoration: none;
        display: inline-block;
        background-color: #111;
        color: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-kembali:hover {
        background-color: #333;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
</style>
