<!DOCTYPE html>
<html>
    <head>
        <title>Prak 305</title>
    </head>

    <body>
        <form method="post">
            <input type="text" name="word">
            <button type="submit" name="press">Submit</button>
        </form>

        <?php 
            if(isset($_POST['press'])) {
                $word = $_POST['word'];
                $length = strlen($word);

                $i = 0;
                while ($i < $length) {
                    $char = strtolower($word[$i]);
                    
                    $j = 0;
                    while ($j < $length){
                        if ($j == 0) {
                            echo strtoupper($char);
                        } else {
                            echo $char;
                        }
                        $j++;
                    }
                    $i++;
                }
            }
        ?>
    </body>
</html>