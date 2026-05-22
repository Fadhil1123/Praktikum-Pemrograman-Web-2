<?php

require_once __DIR__ . '/models/model.php';

$memberResult = getMember();
$bookResult = getBook();
$peminjamanResult = getPeminjaman();

function row_count_or_zero($result)
{
	return $result instanceof mysqli_result ? mysqli_num_rows($result) : 0;
}

$memberCount = row_count_or_zero($memberResult);
$bookCount = row_count_or_zero($bookResult);
$peminjamanCount = row_count_or_zero($peminjamanResult);

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Modul 5 - Perpustakaan</title>
	<meta name="theme-color" content="#0f172a">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="app-page">
	<div class="app-bg"></div>
	<div class="container py-4 py-lg-5">
		<div class="app-hero card border-0 shadow-sm mb-4">
			<div class="card-body p-4 p-lg-5">
				<div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
					<div>
						<div class="app-kicker mb-2">Modul 5 Perpustakaan</div>
						<h1 class="display-6 fw-bold mb-2 text-white">Sistem Perpustakaan</h1>
						<p class="mb-0 text-white-50">Halaman utama untuk membuka data member, buku, dan peminjaman.</p>
					</div>
					<div class="d-flex gap-2 flex-wrap">
						<a class="btn btn-light btn-sm fw-semibold" href="member/member.php">Member</a>
						<a class="btn btn-outline-light btn-sm fw-semibold" href="buku/buku.php">Buku</a>
						<a class="btn btn-outline-light btn-sm fw-semibold" href="peminjaman/peminjaman.php">Peminjaman</a>
					</div>
				</div>
			</div>
		</div>

		<div class="row g-4 justify-content-center">
			<div class="col-12 col-md-6 col-lg-4">
				<div class="app-card card border-0 shadow-sm h-100 card-member">
					<div class="card-body p-4 d-flex flex-column">
						<div class="d-flex justify-content-between align-items-start mb-4">
							<div>
								<div class="card-title-large">Member</div>
								<div class="card-meta"><?php echo $memberCount; ?> data</div>
							</div>
							<div class="card-icon"><i class="bi bi-people"></i></div>
						</div>
						<a class="btn btn-dark mt-auto" href="member/member.php">Buka halaman member</a>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-6 col-lg-4">
				<div class="app-card card border-0 shadow-sm h-100 card-book">
					<div class="card-body p-4 d-flex flex-column">
						<div class="d-flex justify-content-between align-items-start mb-4">
							<div>
								<div class="card-title-large">Buku</div>
								<div class="card-meta"><?php echo $bookCount; ?> data</div>
							</div>
							<div class="card-icon"><i class="bi bi-book"></i></div>
						</div>
						<a class="btn btn-dark mt-auto" href="buku/buku.php">Buka halaman buku</a>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-6 col-lg-4">
				<div class="app-card card border-0 shadow-sm h-100 card-borrow">
					<div class="card-body p-4 d-flex flex-column">
						<div class="d-flex justify-content-between align-items-start mb-4">
							<div>
								<div class="card-title-large">Peminjaman</div>
								<div class="card-meta"><?php echo $peminjamanCount; ?> data</div>
							</div>
							<div class="card-icon"><i class="bi bi-key-fill"></i></div>
						</div>
						<a class="btn btn-dark mt-auto" href="peminjaman/peminjaman.php">Buka halaman peminjaman</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
