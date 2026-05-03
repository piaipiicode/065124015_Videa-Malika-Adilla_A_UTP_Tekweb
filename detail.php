<?php
// detail.php – READ (Detail Produk)
require_once 'includes/koneksi.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: produk.php"); exit; }

$stmt = $koneksi->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();
if (!$p) { header("Location: produk.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($p['nama']) ?> | Optik Kacamata</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/pink.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container py-4" style="max-width:700px">

  <a href="produk.php" class="btn btn-pink-outline btn-sm mb-3">← Kembali</a>

  <div class="card-pink p-4">
    <div class="mb-3">
      <span class="badge-pink"><?= htmlspecialchars($p['kategori']) ?></span>
    </div>
    <h2><?= htmlspecialchars($p['nama']) ?></h2>
    <p class="text-muted mb-1">Merek: <strong><?= htmlspecialchars($p['merek']) ?></strong></p>

    <hr style="border-color: var(--pink-border)">

    <div class="row g-3 mb-3">
      <div class="col-6">
        <div class="stat-card">
          <div class="stat-number">Rp <?= number_format($p['harga'],0,',','.') ?></div>
          <div class="stat-label">Harga</div>
        </div>
      </div>
      <div class="col-6">
        <div class="stat-card">
          <div class="stat-number" style="color: <?= $p['stok'] < 5 ? '#e53935' : 'var(--pink-500)' ?>">
            <?= $p['stok'] ?>
          </div>
          <div class="stat-label">Stok Tersedia</div>
        </div>
      </div>
    </div>

    <?php if ($p['deskripsi']): ?>
    <h5>Deskripsi</h5>
    <p style="color: var(--text-muted)"><?= nl2br(htmlspecialchars($p['deskripsi'])) ?></p>
    <?php endif; ?>

    <small class="text-muted d-block mt-2">
      Ditambahkan: <?= date('d M Y, H:i', strtotime($p['created_at'])) ?><br>
      Diperbarui: <?= date('d M Y, H:i', strtotime($p['updated_at'])) ?>
    </small>

    <div class="d-flex gap-2 mt-4">
      <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-pink-primary"> <img src="assets/icon/editi.png" width="17" height="18" style="object-fit:contain;"> Edit</a>
      <a href="hapus.php?id=<?= $p['id'] ?>"
         onclick="return confirm('Yakin hapus produk ini?')"
         class="btn btn-pink-danger"> <img src="assets/icon/trash.png" width="21" height="21" style="object-fit:contain;"> Hapus</a>
    </div>
  </div>

</div>

<footer>© <?= date('Y') ?> Optik Kacamata — Maroon Company. All rights reserved.</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>