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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/pink.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container py-4">

  <!-- Header -->
  <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
      <h2 class="mb-1 d-flex align-items-center gap-2">
  <img src="assets/icon/box.png" width="28" height="28" style="object-fit:contain;">
  Daftar Produk
</h2>
      <small class="text-muted"><?= $result->num_rows ?> produk ditemukan</small>
    </div>
    <a href="tambah.php" class="btn btn-pink-primary"> + Tambah Produk</a>
  </div>

  <?php if (isset($_GET['success'])): ?>
  <div class="alert alert-pink-success mb-3">
    √ <?= htmlspecialchars($_GET['success']) ?>
  </div>
  <?php endif; ?>

  <!-- Filter & Search -->
  <form method="GET" class="card-pink p-3 mb-4">
    <div class="row g-2">
      <div class="col-12 col-md-6">
  <div style="position: relative;">
    
    <!-- ICON -->
    <img src="assets/icon/search-data.png"
         style="position:absolute;
                top:50%;
                left:12px;
                transform:translateY(-50%);
                width:18px;
                opacity:0.6;">

    <!-- INPUT -->
    <input type="text" name="search" class="form-control"
           placeholder="Cari nama atau merek..."
           value="<?= htmlspecialchars($search) ?>"
           style="padding-left:40px;">
           
  </div>
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
            <th>No</th>
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
            <td><?= htmlspecialchars($p['nama']) ?></td>
            <td><span class="badge-pink"><?= htmlspecialchars($p['kategori']) ?></span></td>
            <td><?= htmlspecialchars($p['merek']) ?></td>
            <td>Rp <?= number_format($p['harga'],0,',','.') ?></td>
            <td>
              <span class="<?= $p['stok'] < 5 ?>">
                <?= $p['stok'] ?>
              </span>
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="detail.php?id=<?= $p['id'] ?>"
                   class="btn btn-pink-outline btn-sm"><img src="assets/icon/info.png" width="20" height="19" style="object-fit:contain;"> Detail</a>
                <a href="edit.php?id=<?= $p['id'] ?>"
                   class="btn btn-pink-primary btn-sm"><img src="assets/icon/edit.png" width="20" height="19" style="object-fit:contain;"></a>
                <a href="hapus.php?id=<?= $p['id'] ?>"
                   onclick="return confirm('Yakin hapus produk \'<?= addslashes($p['nama']) ?>\'?')"
                   class="btn btn-pink-danger btn-sm"><img src="assets/icon/trash.png" width="20" height="19" style="object-fit:contain;"> Hapus</a>
              </div>
            </td>
          </tr>
          <?php endwhile; endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
<footer class="footer-modern" style="background:#2d1f25;color:rgba(255,255,255,0.7);padding:40px 0;margin-top:70px;">  <div class="container">
    <div class="row text-center text-md-start">

      <!-- Brand -->
      <div class="col-12 col-md-4 mb-3">
        <h5 style="font-family:'Cormorant Garamond', serif; color:#f9c8d3;">
          Optik Kacamata
        </h5>
        <p style="font-size:0.85rem;">
          Menyediakan koleksi kacamata premium dengan desain elegan dan kualitas terbaik untuk menunjang gaya dan kenyamanan Anda.
        </p>
      </div>

      <!-- Navigasi -->
      <div class="col-12 col-md-4 mb-3">
        <h6 style="color:#f9c8d3;">Navigasi</h6>
        <ul style="list-style:none;padding:0;font-size:0.85rem;">
          <li><a href="index.php" style="color:inherit;text-decoration:none;">Beranda</a></li>
          <li><a href="produk.php" style="color:inherit;text-decoration:none;">Produk</a></li>
          <li><a href="tambah.php" style="color:inherit;text-decoration:none;">Tambah Produk</a></li>
        </ul>
      </div>

      <!-- Info -->
     <div class="col-12 col-md-3">
        <h6 style="color:#f9c8d3;">Informasi</h6>
        <p><i class="fas fa-map-marker-alt me-2"></i>Indonesia</p>
        <p><i class="fas fa-envelope me-2"></i>support@optik.com</p>
        <p><i class="fas fa-phone me-2"></i>+021-7721-5140</p>
      </div>

    </div>

    <hr style="border-color:rgba(255,255,255,0.1);">

    <div class="text-center" style="font-size:0.8rem;">
      © <?= date('Y') ?> <strong>Optik Kacamata</strong>. All Rights Reserved. <br>
      <span style="opacity:0.6;">Crafted with precision & elegance.</span>
    </div>
  </div>
</footer>

</body>
</html>