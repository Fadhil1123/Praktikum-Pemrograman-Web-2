<!DOCTYPE html>
<html>
<head>
    <style>
        .radio-option input[type="radio"] {
            accent-color: #007bff;
        }
        .convert-btn:active {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
    </style>
    <title>PRAK203</title>
</head>
<body>
    <?php
        function convertTemperature(float $nilai, string $dari, string $ke): float {
            switch ($dari) {
                case "celcius":
                    $celcius = $nilai;
                    break;
                case "fahrenheit":
                    $celcius = 5 / 9 * ($nilai - 32);
                    break;
                case "reamur":
                    $celcius = 5 / 4 * $nilai;
                    break;
                case "kelvin":
                    $celcius = $nilai - 273;
                    break;
                default:
                    return $nilai;
            }

            switch ($ke) {
                case "celcius":
                    return $celcius;
                case "fahrenheit":
                    return (9 / 5 * $celcius) + 32;
                case "reamur":
                    return 4 / 5 * $celcius;
                case "kelvin":
                    return $celcius + 273;
                default:
                    return $nilai;
            }
        }

        $nilaiInput = $_POST["nilai"] ?? "";
        $dari = $_POST["dari"] ?? "";
        $ke = $_POST["ke"] ?? "";
        $isSubmitted = isset($_POST["konversi"]);
    ?>
    <form action="" method="post">
        Nilai : <input type="number" name="nilai" value="<?=$nilaiInput?>"><br>
        Dari : <br>
        <label class="radio-option"><input type="radio" name="dari" value="celcius" <?php if ($dari == "celcius") echo "checked";?>>Celcius</label><br>
        <label class="radio-option"><input type="radio" name="dari" value="fahrenheit" <?php if ($dari == "fahrenheit") echo "checked";?>>Fahrenheit</label><br>
        <label class="radio-option"><input type="radio" name="dari" value="reamur" <?php if ($dari == "reamur") echo "checked";?>>Rheamur</label><br>
        <label class="radio-option"><input type="radio" name="dari" value="kelvin" <?php if ($dari == "kelvin") echo "checked";?>>Kelvin</label><br>
        Ke : <br>
        <label class="radio-option"><input type="radio" name="ke" value="celcius" <?php if ($ke == "celcius") echo "checked";?>>Celcius</label><br>
        <label class="radio-option"><input type="radio" name="ke" value="fahrenheit" <?php if ($ke == "fahrenheit") echo "checked";?>>Fahrenheit</label><br>
        <label class="radio-option"><input type="radio" name="ke" value="reamur" <?php if ($ke == "reamur") echo "checked";?>>Rheamur</label><br>
        <label class="radio-option"><input type="radio" name="ke" value="kelvin" <?php if ($ke == "kelvin") echo "checked";?>>Kelvin</label><br>
        <button type="submit" name="konversi" class="convert-btn">Konversi</button>
    </form>
    <?php
        if ($isSubmitted && !empty($dari) && !empty($ke)) {
            $nilai = (float) $nilaiInput;
            $simbolSatuan = [
                "celcius" => "C",
                "fahrenheit" => "F",
                "reamur" => "R",
                "kelvin" => "K",
            ];

            if ($dari === "celcius" && $ke === "celcius") {
                $hasilTampil = $nilaiInput . " &degC";
            } else {
                $hasilKonversi = convertTemperature($nilai, $dari, $ke);

                if ($dari === $ke) {
                    $hasilTampil = number_format($nilai, 1) . " &deg" . $simbolSatuan[$ke];
                } else {
                    $hasilTampil = number_format($hasilKonversi, 1) . " &deg" . $simbolSatuan[$ke];
                }
            }

            echo "<h1>Hasil Konversi: " . $hasilTampil . "</h1>";
        }
    ?>
</body> </html>