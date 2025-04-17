<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = "";     // Ganti dengan password database Anda
$dbname = "kasir";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari form
$namaProduk = $_POST['namaProduk'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

// Query untuk menyimpan data ke tabel Produk
$sql = "INSERT INTO Produk (NamaProduk, Harga, Stok) VALUES ('$namaProduk', $harga, $stok)";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hasil Simpan Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* General Styles */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f7f7f7;
      color: #333;
      padding: 50px;
    }

    .container {
      max-width: 500px;
      margin: 0 auto;
    }

    .card {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .card-header {
      background-color: #333;
      color: white;
      font-size: 1.5rem;
      text-align: center;
      padding: 20px;
      border-radius: 8px 8px 0 0;
    }

    .alert-success {
      background-color: #e0e0e0;
      color: #333;
      padding: 20px;
      border-radius: 8px;
      font-size: 1.2rem;
      text-align: center;
      margin-bottom: 30px;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
      padding: 20px;
      border-radius: 8px;
      font-size: 1.2rem;
      text-align: center;
      margin-bottom: 30px;
    }

    .btn-custom {
      display: inline-block;
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      background-color: #333;
      color: white;
      transition: all 0.3s ease;
      text-align: center;
      margin-top: 10px;
    }

    .btn-custom:hover {
      background-color: #555;
      transform: translateY(-2px);
    }

    .btn-custom:active {
      transform: scale(0.98);
      background-color: #222;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      body {
        padding: 20px;
      }

      .card {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2>Hasil Simpan Produk</h2>
      </div>

      <?php
      if ($conn->query($sql) === TRUE) {
          echo "<div class='alert alert-success'>✅ Produk berhasil ditambahkan!</div>";
          echo "<a href='input_produk.html' class='btn-custom'>+ Tambah Lagi</a>";
          echo "<a href='index.php' class='btn-custom'>← Kembali ke Halaman Utama</a>";
      } else {
          echo "<div class='alert alert-error'>❌ Error: " . $conn->error . "</div>";
      }

      // Menutup koneksi
      $conn->close();
      ?>
    </div>
  </div>

</body>
</html>
