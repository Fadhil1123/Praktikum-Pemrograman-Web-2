<!DOCTYPE html>
<html>

<head>
    <title>Prak 304</title>
</head>

<body>
    <?php
    $star = 0;
    if (isset($_POST['star'])) {
        $star = (int) $_POST['star'];
    }

    if (isset($_POST['plus'])) {
        $star++;
    }

    if (isset($_POST['min'])) {
        if ($star > 0) {
            $star--;
        }
    }
    ?>

    <?php
    if (isset($_POST['star'])) {
        echo "Jumlah bintang " . $star . "<br><br>";

        $i = 0;
        while ($i < $star) {
            echo "<img src='https://www.freepnglogos.com/uploads/star-png/star-vector-png-transparent-image-pngpix-21.png' width='50' height='50'>";
            $i++;
        }

        ?>
        <form method="post">
            <input type="hidden" name="star" value="<?php echo $star; ?>">

            <button type="submit" name="plus">Tambah</button>
            <button type="submit" name="min">Kurang</button>
        </form>
        <?php
    } else {
        ?>

        <form method="post">
            Jumlah bintang
            <input type="number" name="star" required> <br><br>
            <button type="submit">Submit</button>
        </form>

        <?php
    }
    ?>

</body>
</html>