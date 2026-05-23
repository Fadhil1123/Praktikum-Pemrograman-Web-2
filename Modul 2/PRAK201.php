<!DOCTYPE html>
<html>
    <head>
        <title>PRAK201</title>
    </head>

    <body>
        <form method="POST">
            <label>Nama: 1 </label>
            <input type="text" name="name1"><br>
            <label>Nama: 2 </label>
            <input type="text" name="name2"><br>
            <label>Nama: 3 </label>
            <input type="text" name="name3"><br>

            <input type="submit" name="urutkan" value="Urutkan">
        </form>

        <?php
        if (isset($_POST['urutkan'])) {
            $name1 = $_POST['name1'];
            $name2 = $_POST['name2'];
            $name3 = $_POST['name3'];

            if ($name1 <= $name2 and $name1 <= $name3){
                if ($name2 <= $name3){
                    echo $name1 . "<br>";
                    echo $name2 . "<br>";
                    echo $name3 . "<br>";
                } else {
                    echo $name1 . "<br>";
                    echo $name3 . "<br>";
                    echo $name2 . "<br>";
                }
            } else if ($name2 <= $name1 and $name2 <= $name3){
                if ($name1 <= $name3){
                    echo $name2 . "<br>";
                    echo $name1 . "<br>";
                    echo $name3 . "<br>";
                } else {
                    echo $name2 . "<br>";
                    echo $name3 . "<br>";
                    echo $name1 . "<br>";
                }
            } else {
                if ($name1 <= $name2){
                    echo $name3 . "<br>";
                    echo $name1 . "<br>";
                    echo $name2 . "<br>";
                } else {
                    echo $name3 . "<br>";
                    echo $name2 . "<br>";
                    echo $name1 . "<br>";
                }
            }
        }
        ?>
    </body>
</html>
