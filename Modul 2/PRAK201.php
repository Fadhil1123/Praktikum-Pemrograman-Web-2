<!DOCTYPE html>
<html>
    <head>
        <title>PRAK201</title>
    </head>

    <body>
        <form method="POST">
            <label>Nama: 1 </label>
            <input type="text" name="nama1"><br>
            <label>Nama: 2 </label>
            <input type="text" name="nama2"><br>
            <label>Nama: 3 </label>
            <input type="text" name="nama3"><br>

            <input type="submit" name="urutkan" value="Urutkan">
        </form>

        <?php
        if (isset($_POST['urutkan'])) {
            $nama1 = $_POST['nama1'];
            $nama2 = $_POST['nama2'];
            $nama3 = $_POST['nama3'];

            if ($nama1 <= $nama2 and $nama1 <= $nama3){
                if ($nama2 <= $nama3){
                    echo $nama1 . "<br>";
                    echo $nama2 . "<br>";
                    echo $nama3 . "<br>";
                } else {
                    echo $nama1 . "<br>";
                    echo $nama3 . "<br>";
                    echo $nama2 . "<br>";
                }
            } else if ($nama2 <= $nama1 and $nama2 <= $nama3){
                if ($nama1 <= $nama3){
                    echo $nama2 . "<br>";
                    echo $nama1 . "<br>";
                    echo $nama3 . "<br>";
                } else {
                    echo $nama2 . "<br>";
                    echo $nama3 . "<br>";
                    echo $nama1 . "<br>";
                }
            } else {
                if ($nama1 <= $nama2){
                    echo $nama3 . "<br>";
                    echo $nama1 . "<br>";
                    echo $nama2 . "<br>";
                } else {
                    echo $nama3 . "<br>";
                    echo $nama2 . "<br>";
                    echo $nama1 . "<br>";
                }
            }
        }
        ?>
    </body>
</html>