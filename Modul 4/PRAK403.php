<!DOCTYPE html>
<html>

<head>
    <title> PRAK 403</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            padding-right: 20px;
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
            "no" => 1,
            "name" => "Ridho",
            "matkul" => [
                [ "matkulName" => "Pemrograman I", "sks" => 2 ],
                [ "matkulName" => "Praktikum Pemrograman I", "sks" => 1 ],
                [ "matkulName" => "Pengantar Lingkungan Lahan Basah", "sks" => 2 ],
                [ "matkulName" => "Arsitektur Komputer", "sks" => 3 ]
            ]
        ],

        [
            "no" => 2,
            "name" => "Ratna",
            "matkul" => [
                [ "matkulName" => "Basis Data I", "sks" => 2 ],
                [ "matkulName" => "Praktikum Basis Data I", "sks" => 1 ],
                [ "matkulName" => "Kalkulus", "sks" => 3 ]
            ]
        ],

        [
            "no" => 3,
            "name" => "Tono",
            "matkul" => [
                [ "matkulName" => "Rekayasa Perangkat Lunak", "sks" => 3 ],
                [ "matkulName" => "Analisis dan Perancangan Sistem", "sks" => 3 ],
                [ "matkulName" => "Komputasi Awan", "sks" => 3 ],
                [ "matkulName" => "Kecerdasan Bisnis", "sks" => 3 ]
            ]
        ]
    ]
        ?>

    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Mata Kuliah diambil</th>
            <th>SKS</th>
            <th>Total SKS</th>
            <th>Keterangan</th>
        </tr>

        <?php foreach ($students as $student): ?>
            <?php
            $totalSKS = 0;

            foreach ($student["matkul"] as $matkul) {
                $totalSKS += $matkul["sks"];
            }
            if ($totalSKS < 7) {
                $keterangan = "Revisi KRS";
                $color = "red";
            } else {
                $keterangan = "Tidak Revisi";
                $color = "green";
            }
            ?>

            <?php foreach ($student['matkul'] as $index => $matkul): ?>

                <tr>
                    <?php if ($index == 0): ?>
                        <td> <?php echo $student['no']; ?> </td>
                        <td> <?php echo $student['name']; ?> </td>

                    <?php else: ?>
                        <td></td>
                        <td></td>
                    <?php endif; ?>

                    <td> <?php echo $matkul['matkulName']; ?> </td>
                    <td> <?php echo $matkul['sks']; ?> </td>

                    <?php if ($index == 0): ?>
                        <td> <?php echo $totalSKS; ?> </td>
                        <td style="background-color: <?php echo $color; ?>;">
                            <?php echo $keterangan; ?>
                        </td>

                    <?php else: ?>
                        <td></td>
                        <td></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
</body>

</html>