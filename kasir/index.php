<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Kasir Natsu</title>
  <link rel="shortcut icon" href="cold.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f1f1f1;
      color: #333;
    }

    .sidebar {
      width: 260px;
      height: 100vh;
      position: fixed;
      background-color: #2e2e2e;
      color: #fff;
      padding-top: 20px;
      transition: all 0.3s ease;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
    }

    .sidebar.collapsed {
      width: 70px;
    }

    .sidebar .brand {
      font-size: 1.4rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 30px;
      color: #ddd;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      color: #ccc;
      text-decoration: none;
      transition: 0.2s;
    }

    .sidebar a:hover {
      background-color: #444;
      color: #fff;
    }

    .sidebar i {
      margin-right: 15px;
      font-size: 1.2rem;
    }

    .sidebar.collapsed a span {
      display: none;
    }

    .content {
      margin-left: 260px;
      padding: 30px;
      transition: margin-left 0.3s ease;
    }

    .collapsed + .content {
      margin-left: 70px;
    }

    .toggle-btn {
      position: absolute;
      top: 15px;
      left: 15px;
      font-size: 1.5rem;
      background: none;
      border: none;
      color: #fff;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
      transition: 0.3s;
      background-color: #fff;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .card .bi {
      font-size: 2.2rem;
      color: #555;
      margin-bottom: 15px;
    }

    .card .btn-outline-primary {
      color: #444;
      border-color: #444;
    }

    .card .btn-outline-primary:hover {
      background-color: #444;
      color: #fff;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }
      .content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div class="brand">Kasir Natsu</div>
    <a href="tambah_pelanggan.php"><i class="bi bi-person-plus"></i><span>Tambah Pelanggan</span></a>
    <a href="input_produk.html"><i class="bi bi-box-seam"></i><span>Tambah Produk</span></a>
    <a href="update_produk.php"><i class="bi bi-arrow-repeat"></i><span>Perbarui Produk</span></a>
    <a href="penjualan.php"><i class="bi bi-cart-check"></i><span>Penjualan</span></a>
    <a href="tampil_produk.php"><i class="bi bi-clipboard-data"></i><span>Daftar Produk</span></a>
    <a href="tampil_pelanggan.php"><i class="bi bi-people"></i><span>Daftar Pelanggan</span></a>
    <a href="tampil_penjualan.php"><i class="bi bi-receipt"></i><span>Daftar Penjualan</span></a>
  </div>

  <!-- Content -->
  <div class="content" id="main-content">
    <div class="container text-center mb-4">
      <img src="logo natsu2.png" alt="Logo Kasir" class="mb-3" style="max-width: 180px;">
      <h1 class="fw-semibold">Selamat Datang di Kasir Natsu</h1>
      <p class="text-muted">Kelola data pelanggan, produk, dan transaksi dengan mudah.</p>
    </div>

    <div class="container">
      <div class="row g-4">

        <!-- Card Template -->
        <div class="col-md-4">
          <div class="card text-center p-3">
            <i class="bi bi-person-plus"></i>
            <h5 class="mt-2">Tambah Pelanggan</h5>
            <p class="text-muted">Tambahkan data pelanggan baru</p>
            <a href="tambah_pelanggan.php" class="btn btn-outline-primary">Tambah</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card text-center p-3">
            <i class="bi bi-box-seam"></i>
            <h5 class="mt-2">Tambah Produk</h5>
            <p class="text-muted">Tambahkan data produk baru</p>
            <a href="input_produk.html" class="btn btn-outline-primary">Tambah</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card text-center p-3">
            <i class="bi bi-arrow-repeat"></i>
            <h5 class="mt-2">Perbarui Produk</h5>
            <p class="text-muted">Perbarui stok dan info produk</p>
            <a href="update_produk.php" class="btn btn-outline-primary">Perbarui</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card text-center p-3">
            <i class="bi bi-cart-check"></i>
            <h5 class="mt-2">Penjualan</h5>
            <p class="text-muted">Lakukan transaksi penjualan</p>
            <a href="penjualan.php" class="btn btn-outline-primary">Buka</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card text-center p-3">
            <i class="bi bi-clipboard-data"></i>
            <h5 class="mt-2">Daftar Produk</h5>
            <p class="text-muted">Lihat semua produk & stok</p>
            <a href="tampil_produk.php" class="btn btn-outline-primary">Lihat</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card text-center p-3">
            <i class="bi bi-people"></i>
            <h5 class="mt-2">Daftar Pelanggan</h5>
            <p class="text-muted">Lihat daftar pelanggan</p>
            <a href="tampil_pelanggan.php" class="btn btn-outline-primary">Lihat</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card text-center p-3">
            <i class="bi bi-receipt"></i>
            <h5 class="mt-2">Daftar Penjualan</h5>
            <p class="text-muted">Riwayat transaksi penjualan</p>
            <a href="tampil_penjualan.php" class="btn btn-outline-primary">Lihat</a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- JS Script -->
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('main-content');
      sidebar.classList.toggle('collapsed');
      content.classList.toggle('collapsed');
    }
  </script>
</body>
</html>
