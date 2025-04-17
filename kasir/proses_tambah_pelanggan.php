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

// Mengambil data dari form
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];

// Query untuk menyimpan data pelanggan
$sql = "INSERT INTO Pelanggan (NamaPelanggan, Alamat, NomorTelepon) VALUES ('$nama', '$alamat', '$telepon')";

if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success text-center'>
            <h2>Pelanggan Berhasil Ditambahkan!</h2>
            <p>Data pelanggan baru telah berhasil disimpan.</p>
            <div class='btn-container'>
                <a href='tambah_pelanggan.php' class='btn btn-back'>Kembali ke Form Tambah Pelanggan</a>
                <a href='index.php' class='btn btn-primary'>Kembali ke Halaman Utama</a>
            </div>
          </div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi
$conn->close();
?>
<style>
    /* General Styles */
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background-color: #f4f7fa;
        padding: 20px;
    }

    h1, h2 {
        color:rgb(0, 0, 0);
    }

    .alert {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 40px;
        max-width: 600px;
        margin: 30px auto;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .alert-success {
        background-color: #e8f5e9;
        border-color: #81c784;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 24px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        text-align: center;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .btn-back {
        background-color:rgb(0, 0, 0);
        color: white;
    }

    .btn-back:hover {
        background-color:rgb(82, 82, 82);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-back:active {
        transform: scale(0.97);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        background-color: #2ecc71;
        color: white;
    }

    .btn-primary:hover {
        background-color: #27ae60;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-primary:active {
        transform: scale(0.97);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>
