<?php
// edit.php – UPDATE dengan Foto
require_once 'includes/koneksi.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: produk.php"); exit; }

// Ambil data produk lama
$stmt = $koneksi->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$produk = $stmt->get_result()->fetch_assoc();
if (!$produk) { header("Location: produk.php"); exit; }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = trim($_POST['nama'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? '');
    $merek     = trim($_POST['merek'] ?? '');
    $harga     = trim($_POST['harga'] ?? '');
    $stok      = trim($_POST['stok'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    
    // 1. Logika Update Foto
    $foto_name = $produk['foto']; // Default pakai foto lama

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $file_tmp  = $_FILES['foto']['tmp_name'];
        $file_name = $_FILES['foto']['name'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed   = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($file_ext, $allowed)) {
            $errors[] = 'Format foto harus JPG, JPEG, PNG, atau WEBP.';
        } elseif ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Ukuran foto maksimal 2MB.';
        } else {
            // Buat nama unik baru
            $foto_name = time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_ext;
            $upload_dir = 'assets/img/produk/';
            
            if (move_uploaded_file($file_tmp, $upload_dir . $foto_name)) {
                // Hapus foto lama dari folder jika ada dan jika ganti foto baru
                if (!empty($produk['foto']) && file_exists($upload_dir . $produk['foto'])) {
                    unlink($upload_dir . $produk['foto']);
                }
            } else {
                $errors[] = 'Gagal mengunggah foto baru.';
            }
        }
    }

    // 2. Validasi Input Teks
    if ($nama === '')      $errors[] = 'Nama produk wajib diisi.';
    if ($kategori === '')  $errors[] = 'Kategori wajib dipilih.';
    if ($merek === '')     $errors[] = 'Merek wajib diisi.';
    if (!is_numeric($harga) || $harga < 0) $errors[] = 'Harga harus angka positif.';
    if (!is_numeric($stok)  || $stok  < 0) $errors[] = 'Stok harus angka positif.';

    if (empty($errors)) {
        // 3. Update Database
        $stmt2 = $koneksi->prepare(
            "UPDATE produk SET nama=?, kategori=?, merek=?, harga=?, stok=?, deskripsi=?, foto=?
             WHERE id=?"
        );
        // Tipe data: sssdissi (7 string/double/int + 1 id int)
        $stmt2->bind_param('sssdissi', $nama, $kategori, $merek, $harga, $stok, $deskripsi, $foto_name, $id);
        
        if ($stmt2->execute()) {
            header("Location: produk.php?success=Produk+berhasil+diperbarui");
            exit;
        } else {
            $errors[] = 'Gagal memperbarui: ' . $koneksi->error;
        }
    }

    // Sinkronisasi data untuk re-render jika error
    $produk['nama']      = $nama;
    $produk['kategori']  = $kategori;
    $produk['merek']     = $merek;
    $produk['harga']     = $harga;
    $produk['stok']      = $stok;
    $produk['deskripsi'] = $deskripsi;
    $produk['foto']      = $foto_name;
}

$kategori_list = ['Kacamata Minus','Kacamata Plus','Kacamata Baca','Kacamata Hitam','Kacamata Anak','Lensa Kontak','Aksesoris'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Produk | Optik Kacamata</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/pink.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container py-4" style="max-width:700px">

  <div class="page-header">
    <h2 class="mb-0"> <img src="assets/icon/editi.png" width="29" height="27" style="object-fit:contain;"> Edit Produk</h2>
    <small class="text-muted">ID: <?= $id ?></medium>
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
    <!-- TAMBAHKAN enctype="multipart/form-data" AGAR BISA UPLOAD -->
    <form method="POST" enctype="multipart/form-data" novalidate>
      <div class="row g-3">

        <div class="col-12 text-center mb-3">
            <label class="form-label d-block text-start">Foto Saat Ini</label>
            <?php if (!empty($produk['foto']) && file_exists('assets/img/produk/' . $produk['foto'])): ?>
                <img src="assets/img/produk/<?= $produk['foto'] ?>" class="img-thumbnail shadow-sm" style="height: 150px;">
            <?php else: ?>
                <div class="p-4 border rounded bg-light text-muted">Tidak ada foto</div>
            <?php endif; ?>
        </div>

        <div class="col-12">
          <label class="form-label">Nama Produk *</label>
          <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($produk['nama']) ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label">Kategori *</label>
          <select name="kategori" class="form-select">
            <option value="">-- Pilih Kategori --</option>
            <?php foreach ($kategori_list as $kat): ?>
            <option value="<?= $kat ?>" <?= $produk['kategori'] === $kat ? 'selected' : '' ?>>
              <?= $kat ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Merek *</label>
          <input type="text" name="merek" class="form-control" value="<?= htmlspecialchars($produk['merek']) ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label">Harga (Rp) *</label>
          <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($produk['harga']) ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label">Stok *</label>
          <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($produk['stok']) ?>">
        </div>

        <div class="col-12">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($produk['deskripsi'] ?? '') ?></textarea>
        </div>

        <!-- INPUT UPLOAD FOTO BARU -->
        <div class="col-12">
          <label class="form-label">Ganti Foto Produk (Opsional)</label>
          <input type="file" name="foto" class="form-control" accept="image/*">
          <div class="form-text">Biarkan kosong jika tidak ingin mengubah foto.</div>
        </div>

        <div class="col-12 d-flex gap-2 mt-2">
          <button type="submit" class="btn btn-pink-primary px-4">Simpan Perubahan</button>
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