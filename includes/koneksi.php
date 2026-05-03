<?php

 
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       
define('DB_PASS', '');           
define('DB_NAME', 'db_optik_kacamata');
 
$koneksi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 
if ($koneksi->connect_error) {
    die('<div style="font-family:sans-serif;color:red;padding:20px;">
         ❌ Koneksi gagal: ' . $koneksi->connect_error . '
         <br>Pastikan HeidiSQL / MySQL sudah berjalan dan konfigurasi di file ini sudah benar.
         </div>');
}
 
$koneksi->set_charset('utf8mb4');
?>
 