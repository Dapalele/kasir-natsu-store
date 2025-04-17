<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Penjualan Putih Elegan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #fff;
      font-family: 'Poppins', sans-serif;
      color: #222;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
    }

    .card {
      background-color: #f8f8f8;
      border-radius: 20px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
      padding: 30px;
      width: 100%;
      max-width: 600px;
    }

    h2 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 25px;
      color: #222;
    }

    label {
      font-weight: 500;
      margin-bottom: 5px;
      color: #333;
    }

    .form-control, .form-select {
      background-color: #fff;
      color: #333;
      border: 1px solid #ccc;
      border-radius: 10px;
    }

    .form-control::placeholder {
      color: #aaa;
    }

    .form-control:focus, .form-select:focus {
      background-color: #fff;
      color: #000;
      box-shadow: 0 0 0 2px #00000020;
      border: 1px solid #000;
    }

    .btn-simpan {
      background-color: #111;
      color: #fff;
      border: none;
      font-weight: 600;
      border-radius: 30px;
      transition: 0.3s;
    }

    .btn-simpan:hover {
      background-color: #333;
    }

    .btn-kembali {
      background-color: transparent;
      border: 1px solid #000;
      color: #000;
      font-weight: 600;
      border-radius: 30px;
      transition: 0.3s;
    }

    .btn-kembali:hover {
      background-color: #000;
      color: #fff;
    }

    .kembalian {
      background-color: #eeeeee;
      padding: 15px;
      border-left: 5px solid #111;
      border-radius: 10px;
      margin-top: 20px;
      text-align: center;
      font-weight: bold;
      color: #222;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Form Penjualan</h2>
    <form action="proses_penjualan.php" method="post">
      <div class="mb-3">
        <label for="pelanggan">Pilih Pelanggan:</label>
        <select id="pelanggan" name="pelanggan" class="form-select" required>
          <?php
          $conn = new mysqli("localhost", "root", "", "kasir");
          if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }
          $sql = "SELECT PelangganID, NamaPelanggan FROM Pelanggan";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row["PelangganID"] . "'>" . $row["NamaPelanggan"] . "</option>";
              }
          } else {
              echo "<option value=''>Tidak ada pelanggan</option>";
          }
          $conn->close();
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="produk">Pilih Produk:</label>
        <select id="produk" name="produk" class="form-select" required>
          <?php
          $conn = new mysqli("localhost", "root", "", "kasir");
          if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }
          $sql = "SELECT ProdukID, NamaProduk, Harga FROM Produk";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row["ProdukID"] . "' data-harga='" . $row["Harga"] . "'>" . $row["NamaProduk"] . " (Rp " . number_format($row["Harga"], 2, ',', '.') . ")</option>";
              }
          } else {
              echo "<option value=''>Tidak ada produk</option>";
          }
          $conn->close();
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="uang">Uang yang Diberikan:</label>
        <input type="number" id="uang" name="uang" class="form-control" required>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-simpan px-4">Simpan</button>
        <a href="index.php" class="btn btn-kembali px-4">Kembali</a>
      </div>
    </form>

    <div class="kembalian mt-4" id="kembalian"></div>
  </div>

  <script>
    document.getElementById('uang').addEventListener('input', function () {
      var uang = parseFloat(this.value);
      var produk = document.getElementById('produk');
      var harga = parseFloat(produk.options[produk.selectedIndex].getAttribute('data-harga'));
      var jumlah = parseFloat(document.getElementById('jumlah').value);

      if (!isNaN(uang) && !isNaN(harga) && !isNaN(jumlah)) {
        var totalHarga = harga * jumlah;
        var kembalian = uang - totalHarga;

        if (kembalian >= 0) {
          document.getElementById('kembalian').innerText = "Kembalian: Rp " + kembalian.toLocaleString('id-ID', {minimumFractionDigits: 2});
        } else {
          document.getElementById('kembalian').innerText = "Uang tidak cukup!";
        }
      } else {
        document.getElementById('kembalian').innerText = "";
      }
    });
  </script>
</body>
</html>
