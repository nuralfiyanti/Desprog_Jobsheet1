<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Data Dosen</title>
<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #fdf6fa;
        margin: 0;
        padding: 20px;
    }
    h2 {
        text-align: center;
        color: #9933ff;
    }
    table {
        border-collapse: collapse;
        width: 50%;
        margin: 20px auto;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 12px;
        overflow: hidden;
    }
    th {
        background: linear-gradient(135deg, #ff99cc, #9933ff);
        color: white;
        padding: 14px;
        text-align: left;
        font-size: 16px;
    }
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-size: 15px;
    }
    tr:hover {
        background-color: #fbe5f1;
    }
    tr:last-child td {
        border-bottom: none;
    }
</style>
</head>
<body>
<?php
$Dosen = [
    'Nama' => 'Elok Nur Hamdana',
    'Domisili' => 'Malang',
    'Jenis Kelamin' => 'Perempuan'
];
?>

<h2>Data Dosen</h2>
<table>
    <tr>
        <th>Keterangan</th>
        <th>Isi</th>
    </tr>
    <tr>
        <td>Nama</td>
        <td><?php echo $Dosen['Nama']; ?></td>
    </tr>
    <tr>
        <td>Domisili</td>
        <td><?php echo $Dosen['Domisili']; ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td><?php echo $Dosen['Jenis Kelamin']; ?></td>
    </tr>
</table>
</body>
</html>
