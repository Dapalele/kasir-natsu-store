<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjualan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jsPDF dan AutoTable CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        padding: 20px;
        color: #333;
    }

    h1 {
        text-align: center;
        color: #111;
        margin-bottom: 30px;
        font-size: 24px;
        font-weight: bold;
    }

    .form-search {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-search input {
        width: 300px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
        font-size: 14px;
        background-color: #fff;
    }

    .form-search button, .form-search a {
        padding: 10px 20px;
        border: none;
        background-color: #333;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
        margin-top: 10px;
    }

    .form-search a {
        background-color: #777;
    }

    .form-search button:hover, .form-search a:hover {
        background-color: #555;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
        font-size: 14px;
    }

    th {
        background-color: #333;
        color: white;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    .total {
        background-color: #e6e6e6;
        font-weight: bold;
        font-size: 16px;
    }

    .action-buttons {
        margin-top: 30px;
        text-align: center;
    }

    .action-buttons button, .action-buttons a {
        padding: 12px 25px;
        margin: 0 15px;
        border: none;
        border-radius: 4px;
        background-color: #333;
        color: white;
        text-decoration: none;
    }

    .action-buttons a {
        background-color: #777;
    }

    .action-buttons button:hover, .action-buttons a:hover {
        background-color: #555;
    }
</style>


</head>
<body>
<div class="form-search">
    <form method="GET">
        <input type="text" name="cari" placeholder="Cari Nama Pelanggan"
            value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>" />
        <button type="submit">Cari</button>
        <a href="tampil_penjualan.php">Reset</a>
    </form>
</div>


    <table id="tabelPenjualan">
        <thead>
        
    <tr>
        <th>No</th>
        <th>Tanggal Penjualan</th>
        <th>Nama Pelanggan</th>
        <th>Produk</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
        <th>Aksi</th>
    </tr>
</thead>

       
        <tbody>
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
// Proses hapus jika ada parameter 'hapus'
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);

    // Hapus dari detail dulu (karena ada relasi foreign key)
    $conn->query("DELETE FROM DetailPenjualan WHERE PenjualanID = $id");

    // Baru hapus dari tabel utama
    $conn->query("DELETE FROM Penjualan WHERE PenjualanID = $id");

    // Redirect agar tidak memproses ulang penghapusan saat refresh
    header("Location: tampil_penjualan.php");
    exit();
}

            // Query untuk mengambil data penjualan beserta detailnya
            $cari = isset($_GET['cari']) ? $conn->real_escape_string($_GET['cari']) : '';

            $sql = "
                SELECT 
                    p.PenjualanID,
                    p.TanggalPenjualan,
                    pl.NamaPelanggan,
                    pr.NamaProduk,
                    dp.JumlahProduk,
                    dp.Subtotal
                FROM 
                    Penjualan p
                JOIN 
                    Pelanggan pl ON p.PelangganID = pl.PelangganID
                JOIN 
                    DetailPenjualan dp ON p.PenjualanID = dp.PenjualanID
                JOIN 
                    Produk pr ON dp.ProdukID = pr.ProdukID
                " . ($cari ? "WHERE pl.NamaPelanggan LIKE '%$cari%'" : "") . "
                ORDER BY 
                    p.TanggalPenjualan DESC
            ";
            
            $result = $conn->query($sql);

            // Variabel untuk menyimpan total subtotal
            $totalSubtotal = 0;

            // Cek apakah ada data
            if ($result->num_rows > 0) {
                $no = 1;
                // Output data setiap baris
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $no++ . "</td>
                    <td>" . $row["TanggalPenjualan"] . "</td>
                    <td>" . $row["NamaPelanggan"] . "</td>
                    <td>" . $row["NamaProduk"] . "</td>
                    <td>" . $row["JumlahProduk"] . "</td>
                    <td>Rp " . number_format($row["Subtotal"], 2, ',', '.') . "</td>
                    <td>
                        <a href='?hapus=" . $row["PenjualanID"] . "' 
                           class='btn btn-danger btn-sm'
                           onclick=\"return confirm('Yakin ingin menghapus data ini?');\">Hapus</a>
                    </td>
                  </tr>";
            

                    // Menambahkan subtotal ke totalSubtotal
                    $totalSubtotal += $row["Subtotal"];
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center;'>Tidak ada data penjualan.</td></tr>";
            }

            // Menutup koneksi
            $conn->close();
            ?>
        </tbody>
        <!-- Baris untuk menampilkan total subtotal -->
        <tfoot>
            <tr class="total">
                <td colspan="5" style="text-align: right; font-weight: bold;">Total Subtotal:</td>
                <td>Rp <?php echo number_format($totalSubtotal, 2, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- Tombol Cetak PDF -->
    <div class="action-buttons">
    <button onclick="cetakPDF()">Cetak PDF</button>
    <a href="index.php">Kembali</a>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi untuk mencetak PDF
        function cetakPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');

            // Judul laporan
            doc.setFontSize(18);
            doc.text("Laporan Penjualan", 14, 20);

            // Data tabel
            const table = document.getElementById("tabelPenjualan");
            const rows = table.querySelectorAll("tr");

            // Data untuk AutoTable
            const data = [];
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.querySelectorAll("td");
                const rowData = [];
                cells.forEach(cell => {
                    rowData.push(cell.innerText);
                });
                data.push(rowData);
            }

            // Header tabel
            const headers = [];
            rows[0].querySelectorAll("th").forEach(header => {
                headers.push(header.innerText);
            });

            // Buat tabel menggunakan AutoTable
            doc.autoTable({
                head: [headers],
                body: data,
                startY: 30, // Posisi awal tabel
                theme: 'grid', // Tema tabel
                styles: {
                    fontSize: 10,
                    cellPadding: 2,
                    halign: 'left'
                },
                headStyles: {
                    fillColor: [41, 128, 185], // Warna header
                    textColor: [255, 255, 255] // Warna teks header
                },
                footStyles: {
                    fillColor: [41, 128, 185], // Warna footer
                    textColor: [255, 255, 255] // Warna teks footer
                }
            });

            // Simpan PDF
            doc.save("laporan_penjualan.pdf");
        }
    </script>
</body>
</html>