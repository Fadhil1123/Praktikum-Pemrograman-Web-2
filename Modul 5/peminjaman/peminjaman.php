<?php

require_once __DIR__ . '/../models/model.php';

if (isset($_GET['hapus'])) {
	deletePeminjaman((int) $_GET['hapus']);
	header('Location: peminjaman.php');
	exit;
}

$dataPeminjaman = getPeminjaman();
$errorMessage = $dataPeminjaman === false ? mysqli_error($conn) : '';

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Data Peminjaman</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="app-page">
	<div class="app-bg"></div>
	<div class="container py-4 py-lg-5">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
			<div>
				<h1 class="page-title h2 mb-2">Data Peminjaman</h1>
				<p class="page-subtitle">Daftar transaksi peminjaman yang tersimpan di database.</p>
			</div>
			<div class="d-flex gap-2 flex-wrap">
				<a class="btn btn-outline-dark" href="../index.php">Beranda</a>
				<a class="btn btn-dark" href="formPeminjaman.php">Tambah Peminjaman</a>
			</div>
		</div>

		<div class="card table-card animate-in">
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table table-striped table-hover mb-0 align-middle">
						<thead>
							<tr>
								<th>ID Peminjaman</th>
								<th>Peminjam</th>
								<th>Buku</th>
								<th>Tanggal Pinjam</th>
								<th>Tanggal Kembali</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if ($dataPeminjaman === false): ?>
							<tr><td colspan="6"><?php echo htmlspecialchars($errorMessage); ?></td></tr>
						<?php elseif (mysqli_num_rows($dataPeminjaman) === 0): ?>
							<tr><td colspan="6">Tidak ada data peminjaman.</td></tr>
						<?php else: ?>
							<?php while ($row = mysqli_fetch_assoc($dataPeminjaman)): ?>
							<tr>
								<td><?php echo htmlspecialchars($row['id_peminjaman']); ?></td>
								<td><?php echo htmlspecialchars($row['nama_member'] ?? '-'); ?></td>
								<td><?php echo htmlspecialchars($row['judul_buku'] ?? '-'); ?></td>
								<td><?php echo htmlspecialchars($row['tgl_pinjam']); ?></td>
								<td><?php echo htmlspecialchars($row['tgl_kembali']); ?></td>
								<td>
									<a class="btn btn-sm btn-outline-dark" href="?hapus=<?php echo (int) $row['id_peminjaman']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
									<a class="btn btn-sm btn-dark ms-2" href="formPeminjaman.php?id=<?php echo (int) $row['id_peminjaman']; ?>">Edit</a>
								</td>
							</tr>
							<?php endwhile; ?>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
