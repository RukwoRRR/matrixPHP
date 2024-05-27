<?php

require_once 'config.php';
require_once 'MatrixController.php';
$mysqli = getDbConnection();

$controller = new MatrixController($mysqli);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rows'], $_POST['cols'])) {
    $rows = (int)$_POST['rows'];
    $cols = (int)$_POST['cols'];
    $controller->createMatrix($rows, $cols);
}

$matrixes = $controller->listMatrixes();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Matrix Domawnee Task</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            line-height: 1.6;
            background-color: #d0f0f3;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            margin-top: 0px;
            margin-bottom: 0px;
            text-align: center;
            color: lightcoral;
            font-size: 10px;
        }

        form {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        label {
            display: block;
            min-width: 120px;
        }

        input[type="number"] {
            width: 100px;
        }

        .button-container {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: rgba(0, 255, 255, 0.63);
        }

        th,
        td {
            border: 5px solid #026565;
            padding: 8px;
            text-align: center;
        }

        .table-container {
            overflow-x: auto;
        }

    </style>
</head>

<body>
<h1>Выберете матрицу</h1>
<form method="post">
    <div class="form-group">
        <label for="rows">Количество рядов:</label>
        <input type="number" name="rows" id="rows" required>
    </div>
    <div class="form-group">
        <label for="cols">Количество столбцов:</label>
        <input type="number" name="cols" id="cols" required>
    </div>
    <div class="button-container">
        <button type="submit">Создать</button>
    </div>
</form>
<h2>Примечание! Параметры матрицы должны быть натуральными.</h2>

<h1>Ваша матрица</h1>
<?php if (!empty($matrixes)): ?>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Rows</th>
                <th>Columns</th>
                <th>Viewing</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($matrixes as $matrix): ?>
                <tr>
                    <td><?= $matrix['id'] ?></td>
                    <td><?= $matrix['rows'] ?></td>
                    <td><?= $matrix['cols'] ?></td>
                    <td><a href="?id=<?= $matrix['id'] ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>No matrixes found.</p>
<?php endif; ?>

<?php
if (isset($_GET['id'])) {
    echo '<h1>Элементы матриц</h1>';
    $controller->showMatrix((int)$_GET['id']);
}
?>
</body>

</html>
