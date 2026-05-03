<?php
require_once 'includes/koneksi.php';

$search   = trim($_GET['search'] ?? '');
$kategori = $_GET['kategori'] ?? '';

$where = "WHERE 1=1";
$params = [];
$types  = '';

if ($search !== '') {
    $where .= " AND (nama LIKE ? OR merek LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}

if ($kategori !== '') {
    $where .= " AND kategori = ?";
    $params[] = $kategori;
    $types .= 's';
}

$sql = "SELECT * FROM produk $where ORDER BY created_at DESC";
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

<title>Katalog Produk | Optik Kacamata</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">

<style>
body {
  background:#fffaf8;
  font-family:'Outfit',sans-serif;
}

/* HEADER */
.katalog-header {
  text-align:center;
  padding:60px 20px 30px;
}
.katalog-header h1 {
  font-family:'Cormorant Garamond',serif;
  color:#c2556b;
  font-size:clamp(2rem,4vw,3rem);
}
.katalog-header p {
  color:#a07080;
  max-width:500px;
  margin:auto;
}

/* FILTER */
.filter-box {
  background:white;
  padding:15px;
  border-radius:15px;
  border:1px solid #f5e8eb;
}

/* CARD */
.product-card {
  background:white;
  border-radius:20px;
  overflow:hidden;
  border:1px solid #f5e8eb;
  transition:0.3s;
  height:100%;
}
.product-card:hover {
  transform:translateY(-6px);
  box-shadow:0 20px 50px rgba(194,85,107,0.1);
}

.product-img {
  width:100%;
  height:200px;
  object-fit:cover;
}

.product-body {
  padding:18px;
}

.product-name {
  font-family:'Cormorant Garamond',serif;
  font-size:1.2rem;
}

.product-brand {
  font-size:0.8rem;
  color:#a07080;
}

.product-price {
  color:#c2556b;
  font-weight:600;
  margin:8px 0;
}

.btn-detail {
  background:#c2556b;
  color:white;
  border-radius:30px;
  font-size:0.8rem;
  padding:6px 16px;
  text-decoration:none;
}
.btn-detail:hover {
  background:#a94458;
}

/* MOBILE FIX */
@media(max-width:576px){
  .product-img{
    height:180px;
  }
}
</style>

</head>

<body>

<?php include 'includes/navbar.php'; ?>

<!-- HEADER -->
<section class="katalog-header">
  <h1>Katalog Produk</h1>
  <p>Temukan koleksi kacamata terbaik dengan desain elegan & modern.</p>
</section>

<div class="container pb-5">

  <!-- FILTER -->
  <form method="GET" class="filter-box mb-4">
    <div class="row g-2">

      <div class="col-12 col-md-5">
        <input type="text" name="search" class="form-control"
          placeholder="Cari nama atau merek..."
          value="<?= htmlspecialchars($search) ?>">
      </div>

      <div class="col-12 col-md-4">
        <select name="kategori" class="form-select">
          <option value="">Semua Kategori</option>
          <?php foreach($kategori_list as $kat): ?>
            <option value="<?= $kat ?>" <?= $kategori==$kat?'selected':'' ?>>
              <?= $kat ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12 col-md-3 d-grid">
        <button class="btn btn-pink-primary">Filter</button>
      </div>

    </div>
  </form>

  <!-- GRID -->
  <div class="row g-4">

    <?php if ($result->num_rows > 0): ?>
      <?php while($p = $result->fetch_assoc()): ?>

      <div class="col-12 col-sm-6 col-lg-4">

        <div class="product-card">

          <!-- IMAGE -->
          <?php if (!empty($p['foto'])): ?>
            <img src="assets/img/produk/<?= $p['foto'] ?>" class="product-img">
          <?php else: ?>
            <div class="product-img d-flex justify-content-center align-items-center" style="background:#f5f5f5;">
              <span style="color:#999;">No Image</span>
            </div>
          <?php endif; ?>

          <!-- BODY -->
          <div class="product-body">
            <div class="product-name"><?= htmlspecialchars($p['nama']) ?></div>
            <div class="product-brand"><?= htmlspecialchars($p['merek']) ?></div>

            <div class="product-price">
              Rp <?= number_format($p['harga'],0,',','.') ?>
            </div>

            <a href="detail.php?id=<?= $p['id'] ?>" class="btn-detail">
              Lihat Detail
            </a>
          </div>

        </div>

      </div>

      <?php endwhile; ?>
    <?php else: ?>

      <div class="text-center py-5">
        <h5>Tidak ada produk</h5>
        <p>Coba ubah filter pencarian kamu.</p>
      </div>

    <?php endif; ?>

  </div>

</div>

<!-- FOOTER -->
<footer class="text-center py-4" style="background:#2d1f25;color:#fff;">
  © <?= date('Y') ?> Optik Kacamata — Premium Catalog.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>