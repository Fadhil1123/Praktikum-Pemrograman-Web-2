<!DOCTYPE html>
<html>
    <head>
        <title>Prak 302</title>
    </head>

    <body>
        <form method="post">
            Tinggi : 
            <input type="text" name="height"> <br>
            Alamat Gambar : 
            <input type="text" name="link"> <br>
            <button name="submit">Cetak</button>
        </form>

        <?php
            if (isset($_POST['height']) && isset($_POST['link'])){
                $height = $_POST['height'];
                $link = $_POST['link'];
                $i = $height;

                while ($i >= 1){
                    $space = 1;
                    while ($space <= ($height - $i)){
                        echo "<span style='display:inline-block; width: 50px;'></span>";
                        $space++;
                    }

                    $j = 1;
                    while ($j <= $i){
                        echo "<img src='$link' width='50px' height='50px'>";
                        $j++;
                    }
                    echo "<br>";
                    $i--;
                }
            }
        ?>

    </body>
</html>