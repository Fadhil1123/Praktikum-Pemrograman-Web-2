<?php
$hp = array(
    "Samsung Galaxy S22",
    "Samsung Galaxy S22+",
    "Samsung Galaxy A03",
    "Samsung Galaxy Xcover 5"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRAK105</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
        }

        table {
            border: 1px solid #000;
            border-spacing: 2px;
            background-color: #ffffff;
        }

        th,
        td {
            border: 1px solid #000;
            background-color: #ffffff;
            padding: 2px 6px;
        }

        th {
            font-weight: bold;
            text-align: center;
            background-color: red;
            font-size: 25px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Daftar Smartphone Samsung</th>
        </tr>
        <?php foreach ($hp as $item): ?>
            <tr>
                <td><?php echo $item; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>