<?php

require_once __DIR__ . '/../models/model.php';

if (isset($_GET['hapus'])) {
	deleteBook((int) $_GET['hapus']);
	header('Location: buku.php');
	exit;
}

$dataBook = getBook();
$errorMessage = $dataBook === false ? mysqli_error($conn) : '';

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Data Buku</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="app-page">
	<div class="app-bg"></div>
	<div class="container py-4 py-lg-5">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
			<div>
				<h1 class="page-title h2 mb-2">Data Buku</h1>
				<p class="page-subtitle">Daftar buku yang tersimpan di database.</p>
			</div>
			<div class="d-flex gap-2 flex-wrap">
				<a class="btn btn-outline-dark" href="../index.php">Beranda</a>
				<a class="btn btn-dark" href="formBuku.php">Tambah Buku</a>
			</div>
		</div>

		<div class="card table-card animate-in">
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table table-striped table-hover mb-0 align-middle">
						<thead>
							<tr>
								<th>ID Buku</th>
								<th>Judul Buku</th>
								<th>Penulis</th>
								<th>Penerbit</th>
								<th>Tahun Terbit</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if ($dataBook === false): ?>
							<tr><td colspan="6"><?php echo htmlspecialchars($errorMessage); ?></td></tr>
						<?php elseif (mysqli_num_rows($dataBook) === 0): ?>
							<tr><td colspan="6">Tidak ada data buku.</td></tr>
						<?php else: ?>
							<?php while ($row = mysqli_fetch_assoc($dataBook)): ?>
							<tr>
								<td><?php echo htmlspecialchars($row['id_buku']); ?></td>
								<td><?php echo htmlspecialchars($row['judul_buku']); ?></td>
								<td><?php echo htmlspecialchars($row['penulis']); ?></td>
								<td><?php echo htmlspecialchars($row['penerbit']); ?></td>
								<td><?php echo htmlspecialchars($row['tahun_terbit']); ?></td>
								<td>
									<a class="btn btn-sm btn-outline-dark" href="?hapus=<?php echo (int) $row['id_buku']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
									<a class="btn btn-sm btn-dark ms-2" href="formBuku.php?id=<?php echo (int) $row['id_buku']; ?>">Edit</a>
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
