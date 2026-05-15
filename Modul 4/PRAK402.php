<!DOCTYPE html>
<html>

<head>
    <title>
        Prak 402
    </title>
    <style>
        table {
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid black;
            padding-right: 30px;
            text-align: left;
        }
        th {
            background-color: lightgray;
        }
    </style>
</head>

<body>
    <?php
    $students = [
        [
            "name" => "Andi",
            "nim" => "2101001",
            "uts" => 87,
            "uas" => 65
        ],
        [
            "name" => "Budi",
            "nim" => "2101002",
            "uts" => 76,
            "uas" => 79
        ],
        [
            "name" => "Tono",
            "nim" => "2101003",
            "uts" => 50,
            "uas" => 41
        ],
        [
            "name" => "Jessica",
            "nim" => "2101004",
            "uts" => 60,
            "uas" => 75
        ]
    ];
    ?>

    <table border="1" cellpadding="10">
        <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Nilai UTS</th>
            <th>Nilai UAS</th>
            <th>Nilai Akhir</th>
            <th>Huruf</th>
        </tr>
        <?php foreach ($students as $student): ?>

            <?php
                $finalScore = 
                    ($student['uts'] * 0.4) +
                    ($student['uas'] * 0.6);

                switch (true) {
                    case ($finalScore >= 80):
                        $grade = "A";
                        break;
                    case ($finalScore >= 70):
                        $grade = "B";
                        break;
                    case ($finalScore >= 60):
                        $grade = "C";
                        break;
                    case ($finalScore >= 50):
                        $grade = "D";
                        break;
                    default:
                        $grade = "E";
                }
                ?>
                <tr>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['nim']; ?></td>
                    <td><?php echo $student['uts']; ?></td>
                    <td><?php echo $student['uas']; ?></td>
                    <td><?php echo rtrim(rtrim(number_format($finalScore, 2), '0'), '.'); ?></td>
                    <td><?php echo $grade; ?></td>
                </tr>
        <?php endforeach ?>
    </table>
</body>

</html>