<?php
$nilaiInput = "";
$hasil = "";

if (isset($_POST["submit"])) {
    $nilaiInput = trim($_POST["nilai"] ?? "");

    if ($nilaiInput !== "" && ctype_digit($nilaiInput)) {
        $nilai = (int) $nilaiInput;

        if ($nilai === 0) {
            $hasil = "Nol";
        } elseif ($nilai >= 1 && $nilai <= 9) {
            $hasil = "Satuan";
        } elseif ($nilai >= 10 && $nilai <= 19) {
            $hasil = "Belasan";
        } elseif ($nilai >= 101 && $nilai <= 999) {
            $hasil = "Ratusan";
        } else {
            $hasil = "Anda Menginput Melebihi Limit Bilangan";
        }
    } else {
        $hasil = "Input harus bilangan cacah";
    }
}
?>
<html>
<head>
    <title>PRAK204</title>
</head>
<body>
    <form method="post">
    <label for="nilai">Nilai : </label>
    <input type="text" id="nilai" name="nilai" value="<?= htmlspecialchars($nilaiInput) ?>"><br>
    <button type="submit" name="submit">Konversi</button>
    </form>
    <?php if ($hasil !== ""): ?>
        <h2>Hasil: <?= $hasil ?></h2>
    <?php endif; ?>
</body>
</html>