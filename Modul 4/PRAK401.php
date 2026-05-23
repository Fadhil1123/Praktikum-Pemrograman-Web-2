<!DOCTYPE html>
<html>
    <head>
        <title>Prak 401</title>
        <style>
            table {
                border-collapse: collapse;
            }
            td {
                width: 25px;
                height: 25px;
                text-align: center;
                border: 1px solid black;
            }
        </style>
    </head>

    <body>
        <form method="post">
            Panjang : <input type="text" name="length" required> <br>
            Lebar : <input type="text" name="width" required> <br>
            Nilai : <input type="text" name="value" required> <br>

            <button type="submit" name="press">Cetak</button>
        </form>

        <?php 
        if (isset($_POST['press'])) {
            $length = (int) $_POST['length'];
            $width = (int) $_POST['width'];
            $input = trim($_POST['value']);

            $array = array_map('intval', explode(" ", $input));

            $totalCell = $length * $width;

            if (count($array) > $totalCell) {
                echo "Panjang nilai tidak sesuai dengan ukuran matriks";
            } else {
                echo "<table border='1'>";
                $index = 0;
                for ($i = 0; $i < $width; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < $length; $j++) {
                        echo "<td>";
                        if (isset($array[$index])) {
                            echo $array[$index];
                        }
                        echo "</td>";
                        $index++;
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        ?>
    </body>
</html>