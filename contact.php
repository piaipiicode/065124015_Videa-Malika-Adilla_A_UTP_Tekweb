<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kontak | Optik Kacamata</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

  <style>
    body {
      background: #fffaf8;
      font-family: 'Outfit', sans-serif;
    }

    .contact-section {
      padding: 60px 0;
    }

    .contact-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.8rem, 4vw, 2.5rem);
      color: #c2556b;
      margin-bottom: 20px;
    }

    .contact-card {
      background: white;
      border-radius: 20px;
      padding: 25px;
      border: 1px solid #f5e8eb;
      height: 100%;
    }

    .form-control {
      border-radius: 10px;
      border: 1px solid #f5c9d3;
      font-size: 0.9rem;
    }

    .btn-pink {
      background: #c2556b;
      color: white;
      border-radius: 30px;
      padding: 10px 25px;
      border: none;
    }

    .btn-pink:hover {
      background: #a94458;
    }

    .contact-info i {
      color: #c2556b;
      margin-right: 10px;
    }

    /* MOBILE FIX */
    @media (max-width: 576px) {
      .contact-card {
        padding: 20px;
      }
    }
  </style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="container contact-section">

  <h2 class="contact-title text-center">Hubungi Kami</h2>

  <div class="row g-4">

    <!-- FORM -->
    <div class="col-12 col-lg-7">
      <div class="contact-card">
        <h5 class="mb-3">Kirim Pesan</h5>

        <form>
          <div class="mb-3">
            <input type="text" class="form-control" placeholder="Nama Anda">
          </div>

          <div class="mb-3">
            <input type="email" class="form-control" placeholder="Email">
          </div>

          <div class="mb-3">
            <textarea class="form-control" rows="4" placeholder="Pesan"></textarea>
          </div>

          <button class="btn btn-pink">Kirim Pesan</button>
        </form>
      </div>
    </div>

    <!-- INFO -->
    <div class="col-12 col-lg-5">
      <div class="contact-card contact-info">
        <h5>Informasi Kontak</h5>

        <p><i class="fas fa-map-marker-alt"></i> Indonesia</p>
        <p><i class="fas fa-envelope"></i> support@optik.com</p>
        <p><i class="fas fa-phone"></i> +62 812-xxxx-xxxx</p>

        <hr>

        <h6>Jam Operasional</h6>
        <p>Senin - Sabtu: 09.00 - 21.00</p>
        <p>Minggu: 10.00 - 18.00</p>
      </div>
    </div>

  </div>
</div>

<footer class="text-center py-4" style="background:#2d1f25;color:#fff;">
  © <?= date('Y') ?> Optik Kacamata — Stay stylish.
</footer>

</body>
</html>