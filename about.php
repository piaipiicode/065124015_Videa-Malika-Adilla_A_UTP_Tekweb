<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tentang Kami | Optik Kacamata</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">

  <style>
    body {
      background: #fffaf8;
      font-family: 'Outfit', sans-serif;
      color: #2d1f25;
    }

    /* HERO */
    .about-hero {
      padding: 80px 20px 50px;
      text-align: center;
      background: linear-gradient(160deg,#fff5f7,#fde0e7);
    }

    .about-hero h1 {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2rem, 5vw, 3rem);
      color: #c2556b;
    }

    .about-hero p {
      max-width: 600px;
      margin: 15px auto;
      color: #a07080;
      font-size: 0.95rem;
    }

    /* SECTION */
    .about-section {
      padding: 60px 0;
    }

    /* CARD */
    .about-card {
      background: white;
      border-radius: 20px;
      padding: 25px;
      border: 1px solid #f5e8eb;
      transition: 0.3s;
      height: 100%;
    }

    .about-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 15px 40px rgba(194,85,107,0.1);
    }

    .about-icon {
      font-size: 28px;
      color: #c2556b;
      margin-bottom: 12px;
    }

    /* MOBILE FIX */
    @media (max-width: 576px) {
      .about-card {
        padding: 20px;
      }
    }
  </style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<!-- HERO -->
<section class="about-hero">
  <div class="container">
    <h1>Tentang Kami</h1>
    <p>
       Kami percaya bahwa kacamata bukan sekadar alat bantu penglihatan, 
  melainkan bagian dari identitas dan ekspresi diri. Setiap frame yang kami hadirkan 
  merupakan perpaduan antara desain estetika, kualitas material terbaik, dan kenyamanan maksimal, 
  sehingga tidak hanya menunjang penglihatan tetapi juga memperkuat karakter serta gaya personal Anda.
    </p>
  </div>
</section>

<!-- CONTENT -->
<section class="about-section">
  <div class="container">
    <div class="row g-4">

      <!-- CARD 1 -->
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="about-card text-center">
          <div class="about-icon">-✧</div>
          <h5>Kualitas Premium</h5>
          <p>Kami hanya menyediakan produk berkualitas tinggi dengan material terbaik.</p>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="about-card text-center">
          <div class="about-icon">☆˖°</div>
          <h5>Desain Elegan</h5>
          <p>Setiap frame dirancang untuk memperkuat karakter dan gaya Anda.</p>
        </div>
      </div>

      <!-- CARD 3 -->
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="about-card text-center">
          <div class="about-icon">♡˚</div>
          <h5>Kenyamanan</h5>
          <p>Kenyamanan visual menjadi prioritas utama dalam setiap produk kami.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="text-center py-4" style="background:#2d1f25;color:#fff;">
  © <?= date('Y') ?> Optik Kacamata — Crafted with elegance.
</footer>

</body>
</html>