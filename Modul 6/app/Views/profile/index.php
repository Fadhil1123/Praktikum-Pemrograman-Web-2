<?= $this->include('layouts/header'); ?>

<div class="container py-5 fade-section">

    <h2 class="text-center section-title mb-5">
        Profil Praktikan
    </h2>

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card profile-card">

                <div class="card-body p-5 text-center">

                    <img src="<?= base_url('assets/img/profile.jpg'); ?>"
                        class="profile-img mb-4">

                    <h3>
                        <?= $profile['nama']; ?>
                    </h3>

                    <hr>

                    <p>
                        <strong>NIM :</strong>
                        <?= $profile['nim']; ?>
                    </p>

                    <p>
                        <strong>Program Studi :</strong>
                        <?= $profile['prodi']; ?>
                    </p>

                    <p>
                        <strong>Hobi :</strong>
                        <?= $profile['hobi']; ?>
                    </p>

                    <p>
                        <strong>Skill :</strong>
                        <?= $profile['skill']; ?>
                    </p>

                    <a href="<?= base_url('/'); ?>"
                    class="btn btn-lilac mt-3">

                        Kembali ke Beranda
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->include('layouts/footer'); ?>