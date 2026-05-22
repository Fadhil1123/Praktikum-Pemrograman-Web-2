<?php

require_once __DIR__ . '/models/model.php';

$databaseName = '';
$databaseInfo = '';
$memberCount = 0;
$bookCount = 0;
$peminjamanCount = 0;
$connectionOk = isset($conn) && $conn;

if ($connectionOk) {
	$dbResult = mysqli_query($conn, 'SELECT DATABASE() AS database_name');
	if ($dbResult instanceof mysqli_result) {
		$dbRow = mysqli_fetch_assoc($dbResult);
		$databaseName = $dbRow['database_name'] ?? '';
		mysqli_free_result($dbResult);
	}

	$databaseInfo = mysqli_get_host_info($conn);
	$memberResult = getMember();
	$bookResult = getBook();
	$peminjamanResult = getPeminjaman();

	$memberCount = $memberResult instanceof mysqli_result ? mysqli_num_rows($memberResult) : 0;
	$bookCount = $bookResult instanceof mysqli_result ? mysqli_num_rows($bookResult) : 0;
	$peminjamanCount = $peminjamanResult instanceof mysqli_result ? mysqli_num_rows($peminjamanResult) : 0;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Test Database</title>
	<style>
		body { font-family: Arial, sans-serif; margin: 40px; background: #f8fafc; color: #0f172a; }
		.box { max-width: 760px; background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08); }
		table { width: 100%; border-collapse: collapse; margin-top: 16px; }
		th, td { border: 1px solid #cbd5e1; padding: 10px; text-align: left; }
		th { background: #e2e8f0; }
		.ok { color: #15803d; font-weight: bold; }
		.bad { color: #b91c1c; font-weight: bold; }
	</style>
</head>
<body>
	<div class="box">
		<h1>Test Koneksi Database</h1>
		<p>Status: <span class="<?php echo $connectionOk ? 'ok' : 'bad'; ?>"><?php echo $connectionOk ? 'Koneksi berhasil' : 'Koneksi gagal'; ?></span></p>
		<p>Database: <?php echo htmlspecialchars($databaseName); ?></p>
		<p>Info Server: <?php echo htmlspecialchars($databaseInfo); ?></p>

		<table>
			<tr>
				<th>Tabel</th>
				<th>Jumlah Data</th>
			</tr>
			<tr>
				<td>member</td>
				<td><?php echo $memberCount; ?></td>
			</tr>
			<tr>
				<td>buku</td>
				<td><?php echo $bookCount; ?></td>
			</tr>
			<tr>
				<td>peminjaman</td>
				<td><?php echo $peminjamanCount; ?></td>
			</tr>
		</table>

		<p><a href="index.php">Kembali ke index</a></p>
	</div>
</body>
</html>