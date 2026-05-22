<?php

require_once __DIR__ . '/../models/model.php';

if (isset($_GET['hapus'])) {
    deleteMember((int) $_GET['hapus']);
    header('Location: member.php');
    exit;
}

$dataMember = getMember();
$errorMessage = $dataMember === false ? mysqli_error($conn) : '';
$no = 1;

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="app-page">
    <div class="app-bg"></div>
    <div class="container py-4 py-lg-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="page-title h2 mb-2">Data Member</h1>
                <p class="page-subtitle">Daftar member yang tersimpan di database.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a class="btn btn-outline-dark" href="../index.php">Beranda</a>
                <a class="btn btn-dark" href="formMember.php">Tambah Member</a>
            </div>
        </div>

        <div class="card table-card animate-in">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Member</th>
                                <th>Nama Member</th>
                                <th>Nomor Member</th>
                                <th>Alamat</th>
                                <th>Tanggal Mendaftar</th>
                                <th>Tanggal Terakhir Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($dataMember === false) {
                            echo '<tr><td colspan="8">Terjadi kesalahan query: ' . htmlspecialchars($errorMessage) . '</td></tr>';
                        } else if (mysqli_num_rows($dataMember) === 0) {
                            echo '<tr><td colspan="8">Tidak ada data member.</td></tr>';
                        } else {
                            while($row = mysqli_fetch_assoc($dataMember)) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['id_member']); ?></td>
                                <td><?= htmlspecialchars($row['nama_member']); ?></td>
                                <td><?= htmlspecialchars($row['nomor_member']); ?></td>
                                <td><?= htmlspecialchars($row['alamat']); ?></td>
                                <td><?= htmlspecialchars($row['tgl_mendaftar']); ?></td>
                                <td><?= htmlspecialchars($row['tgl_terakhir_bayar']); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-dark" href="formMember.php?id=<?= (int) $row['id_member']; ?>">Edit</a>
                                    <a class="btn btn-sm btn-outline-dark ms-2" href="?hapus=<?= (int) $row['id_member']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>