<?php // includes/navbar.php
$current = basename($_SERVER['PHP_SELF']);
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&family=Playfair+Display:wght@500&display=swap');


.nav-optik {
  background: #fdf0f3;
  border-bottom: 1px solid #f5c9d3;
  padding: 0.5rem 0;
  position: sticky;
  top: 0;
  z-index: 999;
}

.nav-optik .navbar-brand {
  font-family: 'Playfair Display', serif;
  font-weight: 500;
  font-size: 1.1rem;
  color: #c2556b;
  letter-spacing: 0.01em;
  display: flex;
  align-items: center;
  gap: 0.6rem;
  text-decoration: none;
  transition: opacity 0.2s;
}

.nav-optik .brand-logo {
  width:40px;
  height: 40px;
  object-fit: cover;
  border-radius: 50%;
  border: 1px solid #f0b8c4;
}

.nav-optik .navbar-brand:hover {
  opacity: 0.75;
}

.nav-optik .nav-link {
  font-family: 'DM Sans', sans-serif;
  font-weight: 400;
  font-size: 0.85rem;
  color: #9b5060;
  padding: 0.4rem 0.75rem;
  border-radius: 8px;
  transition: background 0.18s, color 0.18s;
  text-decoration: none;
}

.nav-optik .nav-link:hover {
  background: #fde0e7;
  color: #c2556b;
}

.nav-optik .nav-link.aktif {
  background: #f9c8d3;
  color: #b8445a;
  font-weight: 500;
}

.nav-optik .nav-link-cta {
  background: #e8889a;
  color: #fff !important;
  font-weight: 500;
  padding: 0.4rem 1.2rem;
  border-radius: 20px;
}

.nav-optik .nav-link-cta:hover {
  background: #d4707f;
}

.nav-optik .nav-divider {
  width: 1px;
  height: 18px;
  background: #f0b8c4;
  align-self: center;
  margin: 0 0.5rem;
}

/* ========================= */
/* 🔥 TAMBAHAN RESPONSIVE */
/* ========================= */

.navbar-toggler {
  border: none;
}

.navbar-toggler:focus {
  box-shadow: none;
}

/* biar icon burger keliatan */
.navbar-toggler-icon {
  background-image: none;
  width: 24px;
  height: 2px;
  background-color: #c2556b;
  position: relative;
  display: block;
}

.navbar-toggler-icon::before,
.navbar-toggler-icon::after {
  content: "";
  width: 24px;
  height: 2px;
  background-color: #c2556b;
  position: absolute;
  left: 0;
}

.navbar-toggler-icon::before {
  top: -7px;
}

.navbar-toggler-icon::after {
  top: 7px;
}

/* MOBILE */
@media (max-width: 991px) {

  .nav-optik .brand-logo {
    width: 30px;
    height: 30px;
  }

  .navbar-collapse {
    background: #fff;
    margin-top: 10px;
    border-radius: 12px;
    padding: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
  }

  .navbar-nav {
    align-items: flex-start !important;
    gap: 8px;
  }

  .nav-optik .nav-link {
    width: 100%;
    padding: 10px;
  }

  .nav-optik .nav-link-cta {
    width: 100%;
    text-align: center;
  }

  .nav-optik .nav-divider {
    display: none;
  }
}

</style>

<nav class="navbar navbar-expand-lg nav-optik">
  <div class="container">

    <a class="navbar-brand" href="index.php">
      <img src="iconi.jpg" alt="icon" class="brand-logo">
      <span>Optik Kacamata</span>
    </a>

    <button class="navbar-toggler" type="button"
      data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        
<li class="nav-item">
  <a href="index.php" class="nav-link <?= $current === 'index.php' ? 'aktif' : '' ?>">Home</a>
</li>

<li class="nav-item">
  <a href="katalog.php" class="nav-link <?= $current === 'katalog.php' ? 'aktif' : '' ?>">Katalog</a>
</li>

<li class="nav-item">
  <a href="produk.php" class="nav-link <?= $current === 'produk.php' ? 'aktif' : '' ?>">Produk</a>
</li>

<li class="nav-item">
  <a href="about.php" class="nav-link <?= $current === 'about.php' ? 'aktif' : '' ?>">About</a>
</li>

<li class="nav-item">
  <a href="contact.php" class="nav-link <?= $current === 'contact.php' ? 'aktif' : '' ?>">Contact</a>
</li>
        </li>

      </ul>
    </div>

  </div>
</nav>