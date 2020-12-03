<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 20px auto;
        }
        td {
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <table border="1">
        <tr>
            <td colspan="10">Bang cuu Chuong</td>
        </tr>
        <?php
            for ($i = 1; $i <= 10; $i++){
                echo "<tr>";
                for ($j =1; $j <=10; $j++){
                    $value = $i * $j;
                    echo "<td>$i * $j = $value</td>";
                }
            }
        ?>
    </table>
</body>
</html>