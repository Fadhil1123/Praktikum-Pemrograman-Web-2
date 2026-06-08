<!DOCTYPE html>
<html>

<head>
    <title>Data Buku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap"
    rel="stylesheet">

    <link rel="stylesheet"
    href="<?= base_url('css/style.css') ?>">
</head>

<body>

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">

        <h2 class="page-title">Data Buku</h2>

        <div>
            <a href="<?= base_url('buku/create') ?>"
            class="btn btn-success">
                Tambah Buku
            </a>

            <a href="<?= base_url('logout') ?>"
            class="btn btn-danger">
                Logout
            </a>
        </div>

    </div>

    <?php if(session()->getFlashdata('success')) : ?>

        <div class="alert alert-success">

            <?= session()->getFlashdata('success') ?>

        </div>

    <?php endif; ?>

    <?php if(session()->getFlashdata('error')) : ?>

        <div class="alert alert-danger">

            <?= session()->getFlashdata('error') ?>

        </div>

    <?php endif; ?>

    <table class="table table-bordered table-striped">

        <thead>

        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th width="180">Aksi</th>
        </tr>

        </thead>

        <tbody>

        <?php if(empty($buku)) : ?>

            <tr>

                <td colspan="6" class="text-center">

                    Belum ada data buku

                </td>

            </tr>

        <?php else : ?>

            <?php $no = 1; ?>

            <?php foreach($buku as $item) : ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= esc($item['judul']) ?></td>

                    <td><?= esc($item['penulis']) ?></td>

                    <td><?= esc($item['penerbit']) ?></td>

                    <td><?= esc($item['tahun_terbit']) ?></td>

                    <td>

                        <a href="<?= base_url('buku/edit/'.$item['id']) ?>"
                        class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <a href="<?= base_url('buku/delete/'.$item['id']) ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                            Hapus

                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

        </tbody>

    </table>

</div>

</body>
</html>