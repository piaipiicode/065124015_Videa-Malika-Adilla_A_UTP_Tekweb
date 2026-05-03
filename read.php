<?php
// produk.php – READ (Daftar Produk)
require_once 'includes/koneksi.php';

$search    = trim($_GET['search'] ?? '');
$kategori  = $_GET['kategori'] ?? '';

$where = "WHERE 1=1";
$params = [];
$types  = '';

if ($search !== '') {
    $where   .= " AND (nama LIKE ? OR merek LIKE ?)";
    $like     = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types   .= 'ss';
}
if ($kategori !== '') {
    $where   .= " AND kategori = ?";
    $params[] = $kategori;
    $types   .= 's';
}

$sql  = "SELECT * FROM produk $where ORDER BY created_at DESC";
$stmt = $koneksi->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$kategori_list = ['Kacamata Minus','Kacamata Plus','Kacamata Baca','Kacamata Hitam','Kacamata Anak','Lensa Kontak','Aksesoris'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Produk | Optik Kacamata</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/pink-theme.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container py-4">

  <!-- Header -->
  <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
      <h2 class="mb-1">📦 Daftar Produk</h2>
      <small class="text-muted"><?= $result->num_rows ?> produk ditemukan</small>
    </div>
    <a href="tambah.php" class="btn btn-pink-primary">➕ Tambah Produk</a>
  </div>

  <?php if (isset($_GET['success'])): ?>
  <div class="alert alert-pink-success mb-3">
    ✅ <?= htmlspecialchars($_GET['success']) ?>
  </div>
  <?php endif; ?>

  <!-- Filter & Search -->
  <form method="GET" class="card-pink p-3 mb-4">
    <div class="row g-2">
      <div class="col-md-6">
        <input type="text" name="search" class="form-control"
               placeholder="🔍 Cari nama atau merek..."
               value="<?= htmlspecialchars($search) ?>">
      </div>
      <div class="col-md-4">
        <select name="kategori" class="form-select">
          <option value="">-- Semua Kategori --</option>
          <?php foreach ($kategori_list as $kat): ?>
          <option value="<?= $kat ?>" <?= $kategori === $kat ? 'selected' : '' ?>>
            <?= $kat ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-pink-primary">Filter</button>
      </div>
    </div>
  </form>

  <!-- Tabel -->
  <div class="card-pink overflow-hidden">
    <div class="table-responsive">
      <table class="table table-pink mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Merek</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows === 0): ?>
          <tr>
            <td colspan="7" class="text-center py-4 text-muted">
              Tidak ada produk yang ditemukan.
            </td>
          </tr>
          <?php else: $no = 1; while($p = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><strong><?= htmlspecialchars($p['nama']) ?></strong></td>
            <td><span class="badge-pink"><?= htmlspecialchars($p['kategori']) ?></span></td>
            <td><?= htmlspecialchars($p['merek']) ?></td>
            <td>Rp <?= number_format($p['harga'],0,',','.') ?></td>
            <td>
              <span class="badge <?= $p['stok'] < 5 ? 'bg-danger' : 'bg-success' ?>">
                <?= $p['stok'] ?>
              </span>
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="detail.php?id=<?= $p['id'] ?>"
                   class="btn btn-pink-outline btn-sm">👁 Detail</a>
                <a href="edit.php?id=<?= $p['id'] ?>"
                   class="btn btn-pink-primary btn-sm">✏️ Edit</a>
                <a href="hapus.php?id=<?= $p['id'] ?>"
                   onclick="return confirm('Yakin hapus produk \'<?= addslashes($p['nama']) ?>\'?')"
                   class="btn btn-pink-danger btn-sm">🗑 Hapus</a>
              </div>
            </td>
          </tr>
          <?php endwhile; endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<footer>© <?= date('Y') ?> Optik Kacamata — Maroon Company. All rights reserved.</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>