<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tambah Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            padding: 40px 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            color: #000;
        }

        .logo {
            display: block;
            margin: 0 auto 20px; /* Center the logo and add margin */
            width: 100px; /* Adjust the width of the logo */
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            margin-top: 12px;
            font-weight: 500;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.2s ease;
        }

        input:focus,
        textarea:focus {
            border-color: #000;
            outline: none;
        }

        .btn-submit {
            margin-top: 20px;
            background-color: #000;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #333;
        }

        .btn-back {
            display: block;
            margin: 30px auto 0;
            background-color: rgb(0, 0, 0);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;    
            text-align: center;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

    <!-- Logo di atas halaman -->
    <img src="logo natsu2.png" alt="Logo" class="logo"> <!-- Ganti 'logo.png' dengan path logo Anda -->

    <h1>Tambah Pelanggan Baru</h1>
    <div class="form-container">
        <form action="proses_tambah_pelanggan.php" method="post">
            <label for="nama">Nama Pelanggan:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" rows="4" required></textarea>

            <label for="telepon">Nomor Telepon:</label>
            <input type="text" id="telepon" name="telepon" required>

            <button type="submit" class="btn-submit">Simpan Pelanggan</button>
            <a href="index.php" class="btn-back">
    ← Kembali ke Halaman Utama
    </a>
        </form>
    </div>

   

</body>
</html>
