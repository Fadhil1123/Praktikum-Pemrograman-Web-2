<?= $this->include('layouts/header'); ?>

<div class="blob blob-1"></div>


<section class="hero-section fade-section">

    <div class="container">
        <div class="alert alert-light border-start border-5 border-purple shadow-sm mb-5 fade-in-alert alert-dismissible">

            Selamat Datang di Website Portfolio Saya!

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

        <div class="row align-items-center">

            <div class="col-lg-6">

                <h1 class="hero-title">
                    Halo, Saya <?= $profile['nama']; ?>
                </h1>

                <p class="hero-subtitle">
                    Selamat datang di website portfolio saya.
                </p>

                <p>
                    NIM : <?= $profile['nim']; ?>
                </p>

                <a href="<?= base_url('profile'); ?>"
                class="btn btn-lilac btn-lg">

                    Lihat Profil
                </a>

            </div>

            <div class="col-lg-6 text-center">

                <img src="<?= base_url('assets/img/profile.jpg'); ?>"
                    class="img-fluid"
                    width="350">

            </div>

        </div>

    </div>

</section>

<?= $this->include('layouts/footer'); ?>