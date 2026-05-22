<?php

require_once __DIR__ . '/../models/model.php';

$message = '';

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$editing = false;
$editId = null;
$judul_buku_val = '';
$penulis_val = '';
$penerbit_val = '';
$tahun_terbit_val = '';

if (isset($_GET['id'])) {
	$editing = true;
	$editId = (int) $_GET['id'];
	$res = getBookById($editId);
	if ($res && mysqli_num_rows($res) > 0) {
		$row = mysqli_fetch_assoc($res);
		$judul_buku_val = $row['judul_buku'];
		$penulis_val = $row['penulis'];
		$penerbit_val = $row['penerbit'];
		$tahun_terbit_val = $row['tahun_terbit'];
	}
}

if ($requestMethod === 'POST') {
	$judul_buku = trim($_POST['judul_buku'] ?? '');
	$penulis = trim($_POST['penulis'] ?? '');
	$penerbit = trim($_POST['penerbit'] ?? '');
	$tahun_terbit = trim($_POST['tahun_terbit'] ?? '');

	$judul_buku_val = $judul_buku;
	$penulis_val = $penulis;
	$penerbit_val = $penerbit;
	$tahun_terbit_val = $tahun_terbit;

	if (!preg_match('/^\d{4}$/', $tahun_terbit)) {
		$message = 'Tahun terbit harus 4 digit, contoh: 2024.';
	}

	if ($message === '' && isset($_POST['edit_id']) && is_numeric($_POST['edit_id'])) {
		$editId = (int) $_POST['edit_id'];
		if (updateBook($editId, $judul_buku, $penulis, $penerbit, $tahun_terbit)) {
			header('Location: buku.php');
			exit;
		}
		$message = get_app_error() !== '' ? get_app_error() : 'Gagal mengubah data buku.';
	} else if ($message === '') {
		if (addBook($judul_buku, $penulis, $penerbit, $tahun_terbit)) {
			header('Location: buku.php');
			exit;
		}
		$message = get_app_error() !== '' ? get_app_error() : 'Gagal menambah data buku.';
	}
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah Buku</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="app-page">
	<div class="app-bg"></div>
	<div class="container py-4 py-lg-5">
		<div class="mb-4">
			<h1 class="page-title h2 mb-2"><?php echo $editing ? 'Edit Buku' : 'Tambah Buku'; ?></h1>
			<p class="page-subtitle"><?php echo $editing ? 'Perbarui data buku.' : 'Masukkan data buku baru.'; ?></p>
		</div>
		<div class="card form-card animate-in">
			<div class="card-body p-4 p-lg-5">
				<?php if ($message !== ''): ?><div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
				<form method="post" class="row g-3">
					<?php if ($editing): ?><input type="hidden" name="edit_id" value="<?php echo (int) $editId; ?>"><?php endif; ?>
					<div class="col-12">
						<label class="form-label">Judul Buku</label>
						<input type="text" name="judul_buku" class="form-control" value="<?php echo htmlspecialchars($judul_buku_val); ?>" required>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label">Penulis</label>
						<input type="text" name="penulis" class="form-control" value="<?php echo htmlspecialchars($penulis_val); ?>" required>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label">Penerbit</label>
						<input type="text" name="penerbit" class="form-control" value="<?php echo htmlspecialchars($penerbit_val); ?>" required>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label">Tahun Terbit</label>
						<input type="number" name="tahun_terbit" class="form-control" min="1000" max="9999" step="1" value="<?php echo htmlspecialchars($tahun_terbit_val); ?>" required>
					</div>
					<div class="col-12 d-flex gap-2 flex-wrap mt-2">
						<button type="submit" class="btn btn-dark">Simpan</button>
						<a href="buku.php" class="btn btn-outline-dark">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
