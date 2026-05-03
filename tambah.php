<?php
// tambah.php – CREATE dengan Upload Foto
require_once 'includes/koneksi.php';

$errors = [];
$data   = ['nama'=>'','kategori'=>'','merek'=>'','harga'=>'','stok'=>'','deskripsi'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['nama']      = trim($_POST['nama'] ?? '');
    $data['kategori']  = trim($_POST['kategori'] ?? '');
    $data['merek']     = trim($_POST['merek'] ?? '');
    $data['harga']     = trim($_POST['harga'] ?? '');
    $data['stok']      = trim($_POST['stok'] ?? '');
    $data['deskripsi'] = trim($_POST['deskripsi'] ?? '');
    
    // Logika Upload Foto
    $foto_name = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $file_tmp  = $_FILES['foto']['tmp_name'];
        $file_name = $_FILES['foto']['name'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed   = ['jpg', 'jpeg', 'png', 'webp'];

        // Validasi Ekstensi & Ukuran (Contoh: Max 2MB)
        if (!in_array($file_ext, $allowed)) {
            $errors[] = 'Format foto harus JPG, JPEG, PNG, atau WEBP.';
        } elseif ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Ukuran foto maksimal 2MB.';
        } else {
            // Beri nama unik agar tidak bentrok
            $foto_name = time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_ext;
            $upload_dir = 'assets/img/produk/';
            
            // Buat folder jika belum ada
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            
            if (!move_uploaded_file($file_tmp, $upload_dir . $foto_name)) {
                $errors[] = 'Gagal mengunggah foto.';
            }
        }
    }

    // Validasi Input Teks
    if ($data['nama'] === '')     $errors[] = 'Nama produk wajib diisi.';
    if ($data['kategori'] === '') $errors[] = 'Kategori wajib dipilih.';
    if ($data['merek'] === '')    $errors[] = 'Merek wajib diisi.';
    if (!is_numeric($data['harga']) || $data['harga'] < 0) $errors[] = 'Harga harus angka positif.';
    if (!is_numeric($data['stok'])  || $data['stok']  < 0) $errors[] = 'Stok harus angka positif.';

    if (empty($errors)) {
        // Pastikan kolom 'foto' sudah ada di tabel 'produk' database Anda
        $stmt = $koneksi->prepare(
            "INSERT INTO produk (nama, kategori, merek, harga, stok, deskripsi, foto)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('sssdiss',
            $data['nama'], $data['kategori'], $data['merek'],
            $data['harga'], $data['stok'], $data['deskripsi'], $foto_name
        );
        
        if ($stmt->execute()) {
            header("Location: produk.php?success=Produk+berhasil+ditambahkan");
            exit;
        } else {
            $errors[] = 'Gagal menyimpan ke database: ' . $koneksi->error;
        }
    }
}

$kategori_list = ['Kacamata Minus','Kacamata Plus','Kacamata Baca','Kacamata Hitam','Kacamata Anak','Lensa Kontak','Aksesoris'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Produk | Optik Kacamata</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/pink.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container py-4" style="max-width:700px">

  <div class="page-header">
    <h2 class="mb-0">➕ Tambah Produk Baru</h2>
  </div>

  <?php if ($errors): ?>
  <div class="alert alert-danger rounded-3 mb-3">
    <strong>Terdapat kesalahan:</strong>
    <ul class="mb-0 mt-1">
      <?php foreach ($errors as $e): ?>
      <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>

  <div class="card-pink p-4">
    <!-- PENTING: Tambahkan enctype="multipart/form-data" -->
    <form method="POST" enctype="multipart/form-data" novalidate>
      <div class="row g-3">

        <div class="col-12">
          <label class="form-label">Nama Produk *</label>
          <input type="text" name="nama" class="form-control"
                 value="<?= htmlspecialchars($data['nama']) ?>"
                 placeholder="Contoh: Frame Classic Oval">
        </div>

        <div class="col-md-6">
          <label class="form-label">Kategori *</label>
          <select name="kategori" class="form-select">
            <option value="">-- Pilih Kategori --</option>
            <?php foreach ($kategori_list as $kat): ?>
            <option value="<?= $kat ?>" <?= $data['kategori'] === $kat ? 'selected' : '' ?>>
              <?= $kat ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Merek *</label>
          <input type="text" name="merek" class="form-control"
                 value="<?= htmlspecialchars($data['merek']) ?>"
                 placeholder="Contoh: Ray-Ban">
        </div>

        <div class="col-md-6">
          <label class="form-label">Harga (Rp) *</label>
          <input type="number" name="harga" class="form-control" min="0"
                 value="<?= htmlspecialchars($data['harga']) ?>"
                 placeholder="350000">
        </div>

        <div class="col-md-6">
          <label class="form-label">Stok *</label>
          <input type="number" name="stok" class="form-control" min="0"
                 value="<?= htmlspecialchars($data['stok']) ?>"
                 placeholder="10">
        </div>

        <div class="col-12">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="3"
                    placeholder="Deskripsi singkat produk..."><?= htmlspecialchars($data['deskripsi']) ?></textarea>
        </div>

        <!-- INPUT FOTO BARU -->
        <div class="col-12">
          <label class="form-label">Foto Produk</label>
          <input type="file" name="foto" class="form-control" accept="image/*">
          <div class="form-text">Format: JPG, PNG, WEBP. Maks 2MB.</div>
        </div>

        <div class="col-12 d-flex gap-2 mt-2">
          <button type="submit" class="btn btn-pink-primary px-4">Simpan Produk</button>
          <a href="produk.php" class="btn btn-pink-outline px-4">Batal</a>
        </div>

      </div>
    </form>
  </div>

</div>

<footer>© <?= date('Y') ?> Optik Kacamata — Maroon Company. All rights reserved.</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>