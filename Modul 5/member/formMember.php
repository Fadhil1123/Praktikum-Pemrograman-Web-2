<?php

require_once __DIR__ . '/../models/model.php';

$message = '';

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$editing = false;
$editId = null;
$witaNow = new DateTime('now', new DateTimeZone('Asia/Makassar'));
$defaultDateTime = $witaNow->format('Y-m-d\TH:i');
$defaultDate = $witaNow->format('Y-m-d');
$nama_member_val = '';
$nomor_member_val = '';
$alamat_val = '';
$tgl_mendaftar_val = $defaultDateTime;
$tgl_terakhir_bayar_val = $defaultDate;

if (isset($_GET['id'])) {
	$editing = true;
	$editId = (int) $_GET['id'];
	$res = getMemberById($editId);
	if ($res && mysqli_num_rows($res) > 0) {
		$row = mysqli_fetch_assoc($res);
		$nama_member_val = $row['nama_member'];
		$nomor_member_val = $row['nomor_member'];
		$alamat_val = $row['alamat'];
		if (!empty($row['tgl_mendaftar'])) {
			$tsMendaftar = strtotime($row['tgl_mendaftar']);
			if ($tsMendaftar !== false) {
				$tgl_mendaftar_val = date('Y-m-d\\TH:i', $tsMendaftar);
			}
		}
		$tgl_terakhir_bayar_val = $row['tgl_terakhir_bayar'];
	}
}

if ($requestMethod === 'POST') {
	$nama_member = trim($_POST['nama_member'] ?? '');
	$nomor_member = trim($_POST['nomor_member'] ?? '');
	$alamat = trim($_POST['alamat'] ?? '');
	$tgl_mendaftar = trim($_POST['tgl_mendaftar'] ?? '');
	$tgl_terakhir_bayar = trim($_POST['tgl_terakhir_bayar'] ?? '');

	$nama_member_val = $nama_member;
	$nomor_member_val = $nomor_member;
	$alamat_val = $alamat;
	$tgl_mendaftar_val = $tgl_mendaftar;
	$tgl_terakhir_bayar_val = $tgl_terakhir_bayar;

	$tgl_mendaftar = str_replace('T', ' ', $tgl_mendaftar);
	if (strlen($tgl_mendaftar) === 16) {
		$tgl_mendaftar .= ':00';
	}

	if (isset($_POST['edit_id']) && is_numeric($_POST['edit_id'])) {
		$editId = (int) $_POST['edit_id'];
		if (updateMember($editId, $nama_member, $nomor_member, $alamat, $tgl_mendaftar, $tgl_terakhir_bayar)) {
			header('Location: member.php');
			exit;
		}
		$message = 'Gagal mengubah data member.';
	} else {
		if (addMember($nama_member, $nomor_member, $alamat, $tgl_mendaftar, $tgl_terakhir_bayar)) {
			header('Location: member.php');
			exit;
		}
		$message = 'Gagal menambah data member.';
	}
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah Member</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/style.css">
</head>
<body class="app-page">
	<div class="app-bg"></div>
	<div class="container py-4 py-lg-5">
		<div class="mb-4">
			<h1 class="page-title h2 mb-2"><?php echo $editing ? 'Edit Member' : 'Tambah Member'; ?></h1>
			<p class="page-subtitle"><?php echo $editing ? 'Perbarui data member.' : 'Tambahkan member baru ke database.'; ?></p>
		</div>

		<div class="card form-card animate-in">
			<div class="card-body p-4 p-lg-5">
				<?php if ($message !== ''): ?>
					<div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
				<?php endif; ?>

                <form method="post" class="row g-3">
				<?php if ($editing): ?><input type="hidden" name="edit_id" value="<?php echo (int) $editId; ?>"><?php endif; ?>
					<div class="col-12">
						<label class="form-label">Nama Member</label>
					<input type="text" name="nama_member" class="form-control" value="<?php echo htmlspecialchars($nama_member_val); ?>" required>
					</div>

					<div class="col-12 col-md-6">
						<label class="form-label">Nomor Member</label>
						<input type="text" name="nomor_member" class="form-control" value="<?php echo htmlspecialchars($nomor_member_val); ?>" required>
					</div>

					<div class="col-12 col-md-6">
						<label class="form-label">Tanggal Mendaftar</label>
						<input type="datetime-local" name="tgl_mendaftar" class="form-control" value="<?php echo htmlspecialchars($tgl_mendaftar_val); ?>" required>
					</div>

					<div class="col-12">
						<label class="form-label">Alamat</label>
						<textarea name="alamat" rows="3" class="form-control" required><?php echo htmlspecialchars($alamat_val); ?></textarea>
					</div>

					<div class="col-12 col-md-6">
						<label class="form-label">Tanggal Terakhir Bayar</label>
						<input type="date" name="tgl_terakhir_bayar" class="form-control" value="<?php echo htmlspecialchars($tgl_terakhir_bayar_val); ?>" required>
					</div>

					<div class="col-12 d-flex gap-2 flex-wrap mt-2">
						<button type="submit" class="btn btn-dark">Simpan</button>
						<a href="member.php" class="btn btn-outline-dark">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>