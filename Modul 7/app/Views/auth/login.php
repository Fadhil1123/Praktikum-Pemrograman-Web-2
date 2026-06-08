<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap"
    rel="stylesheet">

    <link rel="stylesheet"
    href="<?= base_url('css/style.css') ?>">
</head>
<body class="login-page">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card">

                <div class="card login-card">

                    <div class="login-header">

                        Login Sistem Buku

                    </div>

                    <div class="card-body p-4">

                    <?php if(session()->getFlashdata('error')) : ?>

                        <div class="alert alert-danger">

                            <?= session()->getFlashdata('error') ?>

                        </div>

                    <?php endif; ?>

                    <form action="<?= base_url('login/process') ?>"
                        method="post">

                        <div class="mb-3">

                            <label>Username</label>

                            <input
                                type="text"
                                name="username"
                                class="form-control">

                        </div>

                        <div class="mb-3">

                            <label>Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control">

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            Login

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>