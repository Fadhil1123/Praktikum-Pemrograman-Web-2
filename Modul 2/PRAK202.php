<!DOCTYPE html>
<html>
<head>
    <style>
        .error {color: red;}
        .gender-option {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 6px;
            color: #000;
        }
        .gender-option input[type="radio"] {
            accent-color: #007bff;
        }
    </style>
    <title>PRAK202</title>
</head>
<body>
    <?php
        $namaError = "";
        $nimError = "";
        $genderError = "";

        $isSubmitted = isset($_POST["submit"]);
        $nama = $_POST["nama"] ?? "";
        $nim = $_POST["nim"] ?? "";
        $gender = $_POST["gender"] ?? "";

        if ($isSubmitted) {
            if (empty($nama)) {
                $namaError = "nama tidak boleh kosong";
            }

            if (empty($nim)) {
                $nimError = "nim tidak boleh kosong";
            }

            if (empty($gender)) {
                $genderError = "jenis kelamin tidak boleh kosong";
            }
        }
    ?>

    <form action="" method="post">
        Nama: <input type="text" name="nama" value="<?=$nama?>"><span class="error">* <?php echo $namaError;?></span><br>
        Nim: <input type="text" name="nim" value="<?=$nim?>"><span class="error">* <?php echo $nimError;?></span><br>
        Jenis Kelamin :<span class="error">* <?php echo $genderError;?></span><br>
        <label class="gender-option">
            <input type="radio" name="gender" value="Laki-laki"
                <?php if ($gender == "Laki-laki")
                    echo "checked";?>><span>Laki-laki</span>
        </label><br>
        <label class="gender-option">
            <input type="radio" name="gender" value="Perempuan"
                <?php if ($gender == "Perempuan")
                    echo "checked";?>><span>Perempuan</span>
        </label><br>
        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
        if ($isSubmitted && !empty($nama) && !empty($nim) && !empty($gender)) {
            echo "<h1>Output: </h1>";
            echo $nama . "<br>";
            echo $nim . "<br>";
            echo $gender;
        }
    ?>
</body>
</html>