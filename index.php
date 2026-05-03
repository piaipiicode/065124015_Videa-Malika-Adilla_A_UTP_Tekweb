<?php
// index.php – Halaman Utama
require_once 'includes/koneksi.php';

$total_produk   = $koneksi->query("SELECT COUNT(*) AS c FROM produk")->fetch_assoc()['c'];
$total_stok     = $koneksi->query("SELECT SUM(stok) AS s FROM produk")->fetch_assoc()['s'] ?? 0;
$total_kategori = $koneksi->query("SELECT COUNT(DISTINCT kategori) AS k FROM produk")->fetch_assoc()['k'];
$produk_terbaru = $koneksi->query("SELECT * FROM produk ORDER BY created_at DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Optik Kacamata | Premium Eyewear</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <style>
    :root {
      --rose:    #c2556b;
      --blush:   #f9c8d3;
      --petal:   #fdf0f3;
      --cream:   #fffaf8;
      --muted:   #a07080;
      --ink:     #2d1f25;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      background: var(--cream);
      font-family: 'Outfit', sans-serif;
      color: var(--ink);
      overflow-x: hidden;
    }

    /* ─── NOISE TEXTURE OVERLAY ─── */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 0;
    }

    /* ─── HERO ─── */
    .hero {
      position: relative;
      min-height: 88vh;
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      gap: 0;
      padding: 0 6vw;
      overflow: hidden;
    }

    .hero-bg {
      position: absolute;
      inset: 0;
      background: linear-gradient(160deg, #fff5f7 0%, #ffe8ed 55%, #fdf0f3 100%);
      z-index: -2;
    }

    /* Decorative blob */
    .hero-blob {
      position: absolute;
      right: -80px;
      top: -80px;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle at 40% 40%, #ffd6e0 0%, #ffb3c1 40%, transparent 70%);
      border-radius: 60% 40% 55% 45% / 50% 60% 40% 50%;
      z-index: -1;
      opacity: 0.55;
      animation: blobFloat 8s ease-in-out infinite;
    }

    @keyframes blobFloat {
      0%, 100% { transform: translate(0,0) rotate(0deg); }
      33%       { transform: translate(-20px, 30px) rotate(3deg); }
      66%       { transform: translate(15px, -20px) rotate(-2deg); }
    }

    .hero-left { padding: 80px 0; }

    .hero-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--rose);
      margin-bottom: 20px;
    }

    .hero-eyebrow::before {
      content: '';
      display: block;
      width: 28px;
      height: 1.5px;
      background: var(--rose);
    }

    .hero-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2.8rem, 5vw, 4.8rem);
      font-weight: 600;
      line-height: 1.1;
      color: var(--ink);
      margin-bottom: 22px;
    }

    .hero-title em {
      font-style: italic;
      color: var(--rose);
    }

    .hero-sub {
      font-size: 1rem;
      font-weight: 300;
      color: var(--muted);
      line-height: 1.8;
      max-width: 400px;
      margin-bottom: 36px;
    }

    .btn-hero {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: var(--rose);
      color: #fff;
      font-size: 0.85rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      padding: 14px 32px;
      border-radius: 50px;
      text-decoration: none;
      transition: all 0.3s ease;
      border: 2px solid var(--rose);
    }

    .btn-hero:hover {
      background: transparent;
      color: var(--rose);
    }

    .btn-hero-ghost {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: transparent;
      color: var(--rose);
      font-size: 0.85rem;
      font-weight: 500;
      padding: 14px 24px;
      border-radius: 50px;
      text-decoration: none;
      transition: all 0.25s;
    }

    .btn-hero-ghost:hover { color: var(--ink); }

    /* Hero right — floating visual */
    .hero-right {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 0;
    }

    .hero-frame {
      position: relative;
      width: 380px;
      height: 380px;
    }

    .hero-circle-bg {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      background: linear-gradient(135deg, #ffe0e8 0%, #ffc6d4 100%);
    }

    .hero-glasses-svg {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .hero-tag {
      position: absolute;
      background: white;
      border-radius: 14px;
      padding: 10px 16px;
      box-shadow: 0 8px 30px rgba(194,85,107,0.12);
      font-size: 0.8rem;
      font-weight: 500;
      color: var(--ink);
      white-space: nowrap;
    }

    .hero-tag-1 { bottom: 50px; left: -30px; animation: floatTag 4s ease-in-out infinite; }
    .hero-tag-2 { top: 60px; right: -20px; animation: floatTag 4s ease-in-out infinite 1.5s; }

    @keyframes floatTag {
      0%, 100% { transform: translateY(0); }
      50%       { transform: translateY(-8px); }
    }

    .hero-tag span { color: var(--rose); font-weight: 700; }

    /* ─── STATS STRIP ─── */
    .stats-strip {
      background: var(--ink);
      padding: 40px 6vw;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1px;
    }

    .stat-item {
      padding: 20px 40px;
      border-right: 1px solid rgba(255,255,255,0.08);
      text-align: center;
    }

    .stat-item:last-child { border-right: none; }

    .stat-num {
      font-family: 'Cormorant Garamond', serif;
      font-size: 3rem;
      font-weight: 600;
      color: var(--blush);
      line-height: 1;
    }

    .stat-lbl {
      font-size: 0.72rem;
      font-weight: 500;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.45);
      margin-top: 6px;
    }

    /* ─── SECTION WRAPPER ─── */
    .section { padding: 90px 6vw; }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 48px;
    }

    .section-eyebrow {
      font-size: 0.7rem;
      font-weight: 600;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--rose);
      margin-bottom: 8px;
    }

    .section-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.8rem, 3vw, 2.8rem);
      font-weight: 600;
      color: var(--ink);
      line-height: 1.2;
    }

    .section-link {
      font-size: 0.82rem;
      font-weight: 600;
      color: var(--rose);
      text-decoration: none;
      letter-spacing: 0.04em;
      border-bottom: 1.5px solid var(--blush);
      padding-bottom: 2px;
      transition: border-color 0.2s;
      white-space: nowrap;
    }

    .section-link:hover { border-color: var(--rose); }

    /* ─── PRODUCT GRID ─── */
    .products-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }

    .prod-card {
      background: white;
      border-radius: 20px;
      padding: 28px;
      border: 1px solid #f5e8eb;
      transition: all 0.35s cubic-bezier(0.23, 1, 0.32, 1);
      cursor: default;
      position: relative;
      overflow: hidden;
    }

    .prod-card::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, #fff8fa 0%, #fff 100%);
      opacity: 0;
      transition: opacity 0.3s;
    }

    .prod-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 24px 50px rgba(194,85,107,0.10);
      border-color: var(--blush);
    }

    .prod-card:hover::before { opacity: 1; }

    .prod-card > * { position: relative; }

    .prod-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 20px;
    }

    .prod-cat {
      font-size: 0.68rem;
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--rose);
      background: var(--petal);
      padding: 5px 12px;
      border-radius: 20px;
    }

    .prod-brand {
      font-size: 0.75rem;
      font-weight: 500;
      color: #c4a0a8;
      letter-spacing: 0.04em;
    }

    .prod-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.4rem;
      font-weight: 600;
      color: var(--ink);
      margin-bottom: 8px;
      line-height: 1.25;
    }

    .prod-desc {
      font-size: 0.82rem;
      font-weight: 300;
      color: var(--muted);
      line-height: 1.7;
      margin-bottom: 20px;
    }

    .prod-footer {
      padding-top: 18px;
      border-top: 1px solid #f5e8eb;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
    }

    .prod-price {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--rose);
    }

    .prod-stock {
      font-size: 0.72rem;
      font-weight: 500;
      color: #c4a0a8;
      background: #fdf5f7;
      padding: 4px 10px;
      border-radius: 20px;
    }

    .prod-actions {
      display: flex;
      gap: 10px;
    }

    .act-btn {
      flex: 1;
      padding: 10px 0;
      border-radius: 10px;
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.04em;
      text-align: center;
      text-decoration: none;
      transition: all 0.22s ease;
      border: none;
      cursor: pointer;
    }

    .act-edit {
      background: var(--petal);
      color: var(--rose);
      border: 1.5px solid var(--blush);
    }

    .act-edit:hover {
      background: var(--blush);
      color: var(--rose);
    }

    .act-del {
      background: #fff2f2;
      color: #d64646;
      flex: 0 0 44px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .act-del:hover {
      background: #ffd5d5;
      color: #c23b3b;
    }

    /* ─── EMPTY STATE ─── */
    .empty-state {
      grid-column: 1/-1;
      text-align: center;
      padding: 80px 20px;
      color: var(--muted);
    }

    .empty-state h4 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.6rem;
      margin-bottom: 8px;
      color: var(--ink);
    }

    /* ─── FOOTER ─── */
    footer {
      background: var(--ink);
      color: rgba(255,255,255,0.5);
      padding: 50px 6vw;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.82rem;
    }

    footer .foot-brand {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--blush);
    }

    /* ─── FADE-IN ANIMATION ─── */
    .fade-up {
      opacity: 0;
      transform: translateY(28px);
      animation: fadeUp 0.7s ease forwards;
    }

    @keyframes fadeUp {
      to { opacity: 1; transform: translateY(0); }
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.22s; }
    .delay-3 { animation-delay: 0.34s; }
    .delay-4 { animation-delay: 0.46s; }
    .delay-5 { animation-delay: 0.58s; }
    .delay-6 { animation-delay: 0.70s; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 900px) {
      .hero { grid-template-columns: 1fr; min-height: auto; padding: 0 5vw; }
      .hero-right { display: none; }
      .stats-strip { grid-template-columns: 1fr; gap: 0; }
      .stat-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.08); }
      .products-grid { grid-template-columns: 1fr 1fr; }
      .section { padding: 60px 5vw; }
      footer { flex-direction: column; gap: 12px; text-align: center; }
    }

    @media (max-width: 580px) {
      .products-grid { grid-template-columns: 1fr; }
      .section-header { flex-direction: column; align-items: flex-start; gap: 16px; }
    }
  </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<!-- ══ HERO ══ -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-blob"></div>

  <div class="hero-left">
    <div class="hero-eyebrow fade-up">Premium Eyewear Collection</div>
    <h1 class="hero-title fade-up delay-1">
      Elegansi di<br><em>Setiap Tatapan</em>
    </h1>
    <p class="hero-sub fade-up delay-2">
      Koleksi kacamata pilihan — dari frame klasik hingga desain kontemporer yang mempertegas kepribadianmu.
    </p>
    <div class="d-flex align-items-center gap-3 flex-wrap fade-up delay-3">
      <a href="produk.php" class="btn-hero">Explore Koleksi &rarr;</a>
      <a href="tambah.php" class="btn-hero-ghost"> + Tambah Produk</a>
    </div>
  </div>

  <div class="hero-right fade-up delay-2">
    <div class="hero-frame">
      <div class="hero-circle-bg"></div>
      <div class="hero-glasses-svg">
        <!-- Inline SVG kacamata cat-eye dekoratif -->
        <svg width="240" height="100" viewBox="0 0 240 100" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Lensa kiri cat-eye -->
          <path d="M8 55 Q5 20 45 14 Q80 10 88 45 Q88 72 55 75 Q18 76 8 55Z"
                fill="white" stroke="#c2556b" stroke-width="3.5"/>
          <!-- Lensa kanan cat-eye -->
          <path d="M152 55 Q149 20 189 14 Q224 10 232 45 Q232 72 199 75 Q162 76 152 55Z"
                fill="white" stroke="#c2556b" stroke-width="3.5"/>
          <!-- Bridge -->
          <path d="M88 36 Q105 28 152 36" fill="none" stroke="#c2556b" stroke-width="3" stroke-linecap="round"/>
          <!-- Gagang kiri -->
          <path d="M8 40 Q-10 34 -20 30" fill="none" stroke="#c2556b" stroke-width="3" stroke-linecap="round"/>
          <!-- Gagang kanan -->
          <path d="M232 40 Q250 34 260 30" fill="none" stroke="#c2556b" stroke-width="3" stroke-linecap="round"/>
          <!-- Hiasan kecil di ujung lensa -->
          <circle cx="80" cy="18" r="4" fill="#f9c8d3"/>
          <circle cx="224" cy="18" r="4" fill="#f9c8d3"/>
        </svg>
      </div>
      <div class="hero-tag hero-tag-1">
        <span><?= $total_produk ?>+</span> Koleksi Tersedia
      </div>
      <div class="hero-tag hero-tag-2">
        <span><?= $total_kategori ?></span> Kategori Gaya
      </div>
    </div>
  </div>
</section>

<!-- ══ STATS STRIP ══ -->
<div class="stats-strip">
  <div class="stat-item">
    <div class="stat-num"><?= $total_produk ?></div>
    <div class="stat-lbl">Produk Terpilih</div>
  </div>
  <div class="stat-item">
    <div class="stat-num"><?= number_format($total_stok) ?></div>
    <div class="stat-lbl">Stok Tersedia</div>
  </div>
  <div class="stat-item">
    <div class="stat-num"><?= $total_kategori ?></div>
    <div class="stat-lbl">Kategori Gaya</div>
  </div>
</div>

<!-- ══ NEW ARRIVALS ══ -->
<section class="section">
  <div class="section-header">
    <div>
      <div class="section-eyebrow">New Arrivals</div>
      <h2 class="section-title">Produk Terbaru</h2>
    </div>
    <a href="produk.php" class="section-link">Lihat semua &rarr;</a>
  </div>

  <div class="products-grid">
    <?php
      $delay = 1;
      $has_products = false;
      while ($p = $produk_terbaru->fetch_assoc()):
        $has_products = true;
    ?>
    <div class="prod-card fade-up delay-<?= $delay ?>">
      <div class="prod-top">
        <span class="prod-cat"><?= htmlspecialchars($p['kategori']) ?></span>
        <span class="prod-brand"><?= htmlspecialchars($p['merek']) ?></span>
      </div>
        <?php if (!empty($p['foto'])): ?>
    <div style="margin-bottom:15px;">
      <img src="assets/img/produk/<?= htmlspecialchars($p['foto']) ?>" 
     style="width:100%; height:180px; object-fit:cover;">
    </div>
  <?php else: ?>
    <div style="height:180px; background:#f5f5f5; display:flex; align-items:center; justify-content:center; border-radius:12px; margin-bottom:15px;">
      <span style="color:#999;">No Image</span>
    </div>
  <?php endif; ?>

      <h3 class="prod-name"><?= htmlspecialchars($p['nama']) ?></h3>

      <p class="prod-desc">
        <?= htmlspecialchars(mb_substr($p['deskripsi'] ?? 'Tidak ada deskripsi.', 0, 100)) ?>...
      </p>

      <div class="prod-footer">
        <span class="prod-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
        <span class="prod-stock">Stok: <?= $p['stok'] ?></span>
      </div>

      <div class="prod-actions">
        <a href="edit.php?id=<?= $p['id'] ?>" class="act-btn act-edit">Edit Produk</a>
        <a href="hapus.php?id=<?= $p['id'] ?>"
           onclick="return confirm('Hapus produk ini?')"
           class="act-btn act-del" title="Hapus">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
          </svg>
        </a>
      </div>
    </div>
    <?php $delay = min($delay + 1, 6); endwhile; ?>

    <?php if (!$has_products): ?>
    <div class="empty-state">
      <h4>Belum ada produk</h4>
      <p>Mulai tambahkan koleksi kacamatamu.</p>
      <a href="tambah.php" class="btn-hero mt-4 d-inline-flex"> + Tambah Produk</a>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ══ FOOTER ══ -->
<footer class="footer-modern">
  <div class="container-fluid">
    <div class="row g-4">

      <!-- BRAND -->
      <div class="col-md-4">
        <h6>Optik Kacamata</h6>
        <p class="mt-3">
          Koleksi kacamata premium dengan sentuhan elegansi untuk menunjang gaya dan kenyamanan visual Anda.
        </p>
      </div>

      

      <!-- MENU -->
      <div class="col-md-2">
        <h6>Menu</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="index.php">Beranda</a></li>
          <li class="mb-2"><a href="produk.php">Produk</a></li>
          <li class="mb-2"><a href="tambah.php">Tambah Produk</a></li>
        </ul>
      </div>

      <!-- KONTAK -->
      <div class="col-md-3">
        <h6>Kontak</h6>
        <p><i class="fas fa-map-marker-alt me-2"></i>Indonesia</p>
        <p><i class="fas fa-envelope me-2"></i>support@optik.com</p>
        <p><i class="fas fa-phone me-2"></i>+62 812-xxxx-xxxx</p>
      </div>

      <!-- JAM -->
      <div class="col-md-3">
        <h6>Jam Operasional</h6>
        <p>
          Senin – Sabtu<br>
          <span style="color:#fff;">09.00 – 21.00</span>
        </p>
        <p>
          Minggu<br>
          <span style="color:#fff;">10.00 – 18.00</span>
        </p>
      </div>

    </div>

    <hr class="footer-divider">

    <div class="text-center" style="font-size:0.8rem;">
      © <?= date('Y') ?> <strong>Optik Kacamata</strong>. All Rights Reserved.<br>
      <span style="opacity:0.6;">Minimal design. Maximum elegance.</span>
    </div>
  </div>
</footer> 