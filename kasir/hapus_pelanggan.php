<?php
// Cek apakah ada parameter ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "kasir");

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Hapus pelanggan berdasarkan ID
    $sql = "DELETE FROM Pelanggan WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect balik ke daftar pelanggan
        header("Location: tampil_pelanggan.php");
    } else {
        echo "Error saat menghapus: " . $conn->error;
    }

    $conn->close();
} else {
    echo "ID tidak ditemukan.";
}
?>
