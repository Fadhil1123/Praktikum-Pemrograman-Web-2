<?php

require_once __DIR__ . '/../models/model.php';

$message = '';

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$editing = false;
$editId = null;
$selected_member = null;
$selected_buku = null;
$tgl_pinjam_val = '';
$tgl_kembali_val = '';

// Jika edit, ambil data peminjaman
if (isset($_GET['id'])) {
	$editing = true;
	$editId = (int) $_GET['id'];
	$res = getPeminjamanById($editId);
	if ($res && mysqli_num_rows($res) > 0) {
		$row = mysqli_fetch_assoc($res);
		$selected_member = $row['id_member'] ?? null;
		$selected_buku = $row['id_buku'] ?? null;
		$tgl_pinjam_val = $row['tgl_pinjam'];
		$tgl_kembali_val = $row['tgl_kembali'];
	}
}

// Ambil daftar member dan buku untuk select
$members = getMember();
$books = getBook();

if ($requestMethod === 'POST') {
	$tgl_pinjam = trim($_POST['tgl_pinjam'] ?? '');
	$tgl_kembali = trim($_POST['tgl_kembali'] ?? '');
	$id_member = isset($_POST['id_member']) && $_POST['id_member'] !== '' ? (int) $_POST['id_member'] : null;
	$id_buku = isset($_POST['id_buku']) && $_POST['id_buku'] !== '' ? (int) $_POST['id_buku'] : null;

	$selected_member = $id_member;
	$selected_buku = $id_buku;
	$tgl_pinjam_val = $tgl_pinjam;
	$tgl_kembali_val = $tgl_kembali;

	if (isset($_POST['edit_id']) && is_numeric($_POST['edit_id'])) {
		// update
		$editId = (int) $_POST['edit_id'];
		if (updatePeminjaman($editId, $tgl_pinjam, $tgl_kembali, $id_member, $id_buku)) {
			header('Location: peminjaman.php');
			exit;
		}
		$message = get_app_error() !== '' ? get_app_error() : 'Gagal mengubah data peminjaman.';
	} else {
		// tambah
		if (addPeminjaman($tgl_pinjam, $tgl_kembali, $id_member, $id_buku)) {
			header('Location: peminjaman.php');
			exit;
		}
		$message = get_app_error() !== '' ? get_app_error() : 'Gagal menambah data peminjaman.';
	}
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah Peminjaman</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/style.css">
</head>
<body class="app-page">
	<div class="app-bg"></div>
	<div class="container py-4 py-lg-5">
		<div class="mb-4">
			<h1 class="page-title h2 mb-2"><?php echo $editing ? 'Edit Peminjaman' : 'Tambah Peminjaman'; ?></h1>
			<p class="page-subtitle"><?php echo $editing ? 'Perbarui transaksi peminjaman.' : 'Tambahkan transaksi peminjaman baru.'; ?></p>
		</div>

		<div class="card form-card animate-in">
			<div class="card-body p-4 p-lg-5">
				<?php if ($message !== ''): ?><div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
				<form method="post" class="row g-3">
					<?php if ($editing): ?><input type="hidden" name="edit_id" value="<?php echo (int) $editId; ?>"><?php endif; ?>
					<div class="col-12 col-md-6">
						<label class="form-label">Peminjam</label>
						<select name="id_member" class="form-select" required>
							<option value="">-- Pilih Member --</option>
							<?php if ($members && mysqli_num_rows($members) > 0): while ($m = mysqli_fetch_assoc($members)): ?>
								<option value="<?php echo (int) $m['id_member']; ?>" <?php echo ($selected_member == $m['id_member']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($m['nama_member']); ?></option>
							<?php endwhile; endif; ?>
						</select>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label">Buku</label>
						<select name="id_buku" class="form-select" required>
							<option value="">-- Pilih Buku --</option>
							<?php if ($books && mysqli_num_rows($books) > 0): while ($b = mysqli_fetch_assoc($books)): ?>
								<option value="<?php echo (int) $b['id_buku']; ?>" <?php echo ($selected_buku == $b['id_buku']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($b['judul_buku']); ?></option>
							<?php endwhile; endif; ?>
						</select>
					</div>

					<div class="col-12 col-md-6">
						<label class="form-label">Tanggal Pinjam</label>
						<input type="date" name="tgl_pinjam" class="form-control" value="<?php echo htmlspecialchars($tgl_pinjam_val); ?>" required>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label">Tanggal Kembali</label>
						<input type="date" name="tgl_kembali" class="form-control" value="<?php echo htmlspecialchars($tgl_kembali_val); ?>" required>
					</div>
					<div class="col-12 d-flex gap-2 flex-wrap mt-2">
						<button type="submit" class="btn btn-dark">Simpan</button>
						<a href="peminjaman.php" class="btn btn-outline-dark">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>