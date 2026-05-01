<!DOCTYPE html>
<html>
<head>
    <title>PRAK 303</title>
</head>

<body>
    <form method="post">
        Batas Bawah : 
        <input type="number" name="lower" required> <br>

        Batas Atas :
        <input type="number" name="upper" required> <br>

        <button type="submit">Cetak</button>
    </form>

    <?php 
    if (isset($_POST['lower']) && isset($_POST['upper'])){

        $lower = (int) $_POST['lower'];
        $upper = (int) $_POST['upper'];

        if ($lower > $upper) {
            echo "Batas bawah tidak boleh lebih besar dari batas atas.";
        } else {

            $i = $lower;

            do {
                if (($i + 7) % 5 == 0){
                    echo "<img src='https://www.freepnglogos.com/uploads/star-png/star-vector-png-transparent-image-pngpix-21.png' width='20' height='20'>";
                } else {
                    echo $i;
                }

                echo " ";
                $i++;

            } while ($i <= $upper);
        }
    }
    ?>
</body>
</html>