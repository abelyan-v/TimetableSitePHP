<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schedule";
$conn = new mysqli($servername, $username, $password, $dbname);
$groups_sql = "SELECT `number`,`name`,`faculty` FROM `group` WHERE 1";
$groups_result = mysqli_query($conn, $groups_sql);
$professors_sql = "SELECT `id`,`name`,`position` FROM `professor` WHERE 1";
$professors_result = mysqli_query($conn, $professors_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    Изменение расписания:
    <form method="post" action="action/add.php">
    <table>
        <tr>
            <td>Группа</td>
            <td>
                <select name="group" style="width:100%">
                    <?php
                        while ($groups_row = mysqli_fetch_row($groups_result)) {
                            echo("<option value=\"$groups_row[0]\">$groups_row[1]</option>");
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Преподаватель</td>
            <td>
                <select name="professor" style="width:100%">
                    <?php
                        while ($professors_row = mysqli_fetch_row($professors_result)) {
                            echo("<option value=\"$professors_row[0]\">$professors_row[1]</option>");
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Подгруппа</td>
            <td><input type="text" name="SubGroup" style="width:100%"></td>
        </tr>
        <tr>
            <td>Наименование предмета</td>
            <td><input type="text" name="subject-name" style="width:100%"></td>
        </tr>
        <tr>
            <td>Начало</td>
            <td><input type="text" name="start" style="width:100%"></td>
        </tr>
        <tr>
            <td>Конец</td>
            <td><input type="text" name="finish" style="width:100%"></td>
        </tr>
        <tr>
            <td>Аудитория</td>
            <td><input type="text" name="audiency" style="width:100%"></td>
        </tr>
    </table>
    <input type="submit" value="Добавить">
                    </form>
</body>
</html>


