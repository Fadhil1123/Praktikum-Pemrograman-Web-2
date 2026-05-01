<!DOCTYPE html>
<html>
    <head>
        <title>Prak 301</title>
    </head>

    <body>
        <form method="post">
            Jumlah Peserta :
            <input type="text" name="amount"> <br>
            <button name="submit">Cetak</button>
        </form>
    
    <?php
        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
            $i = 1;

            while ($i <= $amount){
                if ($i % 2 == 1){
                    echo "<h3 style='color:red'>Peserta ke-$i</h3>";
                } else {
                    echo "<h3 style='color:green'>Peserta ke-$i</h3>";
                }
                $i++;
            }
        }
    ?>
    </body>
</html>