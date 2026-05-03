<?php
// hapus.php – DELETE
require_once 'includes/koneksi.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $koneksi->prepare("DELETE FROM produk WHERE id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        header("Location: produk.php?success=Produk+berhasil+dihapus");
    } else {
        header("Location: produk.php?success=Produk+tidak+ditemukan");
    }
} else {
    header("Location: produk.php");
}
exit;