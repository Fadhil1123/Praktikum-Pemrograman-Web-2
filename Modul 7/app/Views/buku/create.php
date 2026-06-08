<!DOCTYPE html>
<html>

<head>
    <title>Tambah Buku</title>

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

    <h2 class="page-title">Tambah Buku</h2>

    <a href="<?= base_url('buku') ?>"
    class="btn btn-secondary mb-3">

        Kembali

    </a>

    <?php if(session()->get('errors')) : ?>

        <div class="alert alert-danger">

            <ul class="mb-0">

                <?php foreach(session()->get('errors') as $error) : ?>

                    <li><?= $error ?></li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>

    <form action="<?= base_url('buku/store') ?>"
        method="post">

        <?= csrf_field() ?>

        <div class="mb-3">

            <label class="form-label">

                Judul

            </label>

            <input
                type="text"
                name="judul"
                class="form-control"
                value="<?= old('judul') ?>">

        </div>

        <div class="mb-3">

            <label class="form-label">

                Penulis

            </label>

            <input
                type="text"
                name="penulis"
                class="form-control"
                value="<?= old('penulis') ?>">

        </div>

        <div class="mb-3">

            <label class="form-label">

                Penerbit

            </label>

            <input
                type="text"
                name="penerbit"
                class="form-control"
                value="<?= old('penerbit') ?>">

        </div>

        <div class="mb-3">

            <label class="form-label">

                Tahun Terbit

            </label>

            <input
                type="number"
                name="tahun_terbit"
                class="form-control"
                value="<?= old('tahun_terbit') ?>">

        </div>

        <button
            type="submit"
            class="btn btn-primary">

            Simpan

        </button>

    </form>

</div>

</body>
</html>