<?php
$group = $_GET["group"];
$StartTimeInitial = $_GET["StartTime"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schedule";
$conn = new mysqli($servername, $username, $password, $dbname);
$schedule_sql = "SELECT `group`,`professor`,`SubGroup`,`name`,`StartTime`,`FinishTime`,`audience` FROM `schedule` WHERE `group`='$group' AND `StartTime` LIKE '$StartTimeInitial%'";
$schedule_result = mysqli_query($conn, $schedule_sql);
$schedule_row = mysqli_fetch_row($schedule_result);
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
    <form method="post" action="action/edit.php">
    <table>
        <tr>
            <td>Группа</td>
            <td>
                <select name="group" style="width:100%">
                    <?php
                        while ($groups_row = mysqli_fetch_row($groups_result)) {
                            if ($schedule_row[0] == $groups_row[0])
                                $selected = "selected";
                            else
                                $selected = "";
                            echo("<option $selected value=\"$groups_row[0]\">$groups_row[1]</option>");
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
                            if ($schedule_row[1] == $professors_row[0])
                                $selected = "selected";
                            else
                                $selected = "";
                            echo("<option $selected value=\"$professors_row[0]\">$professors_row[1]</option>");
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Подгруппа</td>
            <td><input type="text" name="SubGroup" style="width:100%" value="<?php echo($schedule_row[2])?>"></td>
        </tr>
        <tr>
            <td>Наименование предмета</td>
            <td><input type="text" name="subject-name" style="width:100%" value="<?php echo($schedule_row[3])?>"></td>
        </tr>
        <tr>
            <td>Начало</td>
            <td><input type="text" name="start" style="width:100%" value="<?php echo($schedule_row[4])?>"></td>
        </tr>
        <tr>
            <td>Конец</td>
            <td><input type="text" name="finish" style="width:100%" value="<?php echo($schedule_row[5])?>"></td>
        </tr>
        <tr>
            <td>Аудитория</td>
            <td><input type="text" name="audiency" style="width:100%" value="<?php echo($schedule_row[6])?>"></td>
        </tr>
    </table>
    <input type="submit" value="Изменить">
                    </form>
</body>
</html>


