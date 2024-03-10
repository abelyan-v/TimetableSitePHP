<?php
function MonthText($m) {
    switch ($m) {
        case "01":
            return "января";
            break;
        case "02":
            return "февраля";
            break;
        case "03":
            return "марта";
            break;
        case "04":
            return "апреля";
            break;
        case "05":
            return "мая";
            break;
        case "06":
            return "июня";
            break;
        case "07":
            return "июля";
            break;
        case "08":
            return "августа";
            break;
        case "09":
            return "сентября";
            break;
        case "10":
            return "октября";
            break;
        case "11":
            return "ноября";
            break;
        case "12":
            return "декабря";
            break;
    }

}

if (isset($_GET["page"]))
    $page = $_GET["page"];
else
    $page = 0;

if (isset($_GET["group"])) {
    $group = $_GET["group"];
    $where = "AND `group` = '$group'";
    $GetPagesParameter = "group=$group";
}
elseif (isset($_GET["professor"])) {
    $professor = $_GET["professor"];
    $where = "AND `professor` = '$professor'";
    $GetPagesParameter = "professor=$professor";
}
else {
    $where = "";
    if (isset($_GET["a"])) {
        $GetPagesParameter = "a=1";
    }
}

$DayOfWeek = date("w");
$DayOfWeekCalendar = $DayOfWeek - 1;

$InWeek = $page;
$InDay = $InWeek * 7;
$DayStart = date('Y-m-d', strtotime("-$DayOfWeekCalendar days"));
$DayStart = date('Y-m-d', strtotime($DayStart . " +$InDay days"));
$DayFinish = date('Y-m-d', strtotime($DayStart . ' +5 days'));
$DayStartArray = explode("-", $DayStart);
$DayStartArrayMonth = MonthText($DayStartArray[1]);
$DayStartText = "$DayStartArray[2] $DayStartArrayMonth $DayStartArray[0]";
$DayFinishArray = explode("-", $DayFinish);
$DayFinishArrayMonth = MonthText($DayFinishArray[1]);
$DayFinishText = "$DayFinishArray[2] $DayFinishArrayMonth $DayFinishArray[0]";

$InDayStart = date('Y-m-d', strtotime($DayStart . "+7 days"));
$InDayFinish = date('Y-m-d', strtotime($InDayStart . ' +5 days'));
$InDayStartArray = explode("-", $InDayStart);
$InDayStartArrayMonth = MonthText($InDayStartArray[1]);
$InDayStartText = "$InDayStartArray[2] $InDayStartArrayMonth $InDayStartArray[0]";
$InDayFinishArray = explode("-", $InDayFinish);
$InDayFinishArrayMonth = MonthText($InDayFinishArray[1]);
$InDayFinishText = "$InDayFinishArray[2] $InDayFinishArrayMonth $InDayFinishArray[0]";

$AgoWeek = -1;
$AgoDay = $AgoWeek * 7;
$AgoDayStart = date('Y-m-d', strtotime($DayStart . "+$AgoDay days"));
$AgoDayFinish = date('Y-m-d', strtotime($AgoDayStart . ' +5 days'));
$AgoDayStartArray = explode("-", $AgoDayStart);
$AgoDayStartArrayMonth = MonthText($AgoDayStartArray[1]);
$AgoDayStartText = "$AgoDayStartArray[2] $AgoDayStartArrayMonth $AgoDayStartArray[0]";
$AgoDayFinishArray = explode("-", $AgoDayFinish);
$AgoDayFinishArrayMonth = MonthText($AgoDayFinishArray[1]);
$AgoDayFinishText = "$AgoDayFinishArray[2] $AgoDayFinishArrayMonth $AgoDayFinishArray[0]";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schedule";
$conn = new mysqli($servername, $username, $password, $dbname);
//список преподавателей
$professor_sql = "SELECT `id`, `name` FROM `professor` WHERE 1";
$professor_result = mysqli_query($conn, $professor_sql);

//список факультетов
$faculty_sql = "SELECT `id`, `name` FROM `faculty` WHERE 1";
$faculty_result = mysqli_query($conn, $faculty_sql);

//список групп
$group_sql = "SELECT `number`, `name` FROM `group` WHERE 1";
$group_result = mysqli_query($conn, $group_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Расписание</title>
</head>
<body>
    <div class="MainBlock">
        <div class="row">
            <div class="col-auto">Выберите преподавателя</div>
            <div class="col-auto">
                <select name="ProfessorSelect" id="professor-select" class="form-select" style="width:550px;" onchange="ChooseProfessor()">
                    <option>Выберите преподавателя</option>
                    <?php
                    while ($professor_row = mysqli_fetch_row($professor_result)) {
                        $selected = $professor_row[0] === $_GET["professor"] ? 'selected' : '';
                        echo("<option $selected value=\"$professor_row[0]\">$professor_row[1]</option>");
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-auto">
                Выберите факультет:
            </div>
            <div class="col-auto">
                <select name="faculty" id="faculty-select" class="form-select" style="width: 650px;" onchange="ChooseFaculty()">
                    <option>Выберите факультет</option>
                    <?php
                    while ($faculty_row = mysqli_fetch_row($faculty_result)) {
                        echo("<option value=\"$faculty_row[0]\">$faculty_row[1]</option>");
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-auto">Выберите группу:</div>
            <div class="col-auto">
                <select name="group" id="group-select" class="form-select" style="width:200px;" onchange="ChooseGroup()">
                    <option>Выберите группу</option>
                    <?php
                        if (isset($_GET["group"])) {
                            $current_group_sql = "SELECT `name` FROM `group` WHERE `number` = $group";
                            $current_group_result = mysqli_query($conn, $current_group_sql);
                            $current_group_row = mysqli_fetch_row($current_group_result);
                            echo("<option selected>$current_group_row[0]</option>");
                        }
                    ?>
                </select>
            </div>
        </div>

        <?php
            $Monday = date('Y-m-d', strtotime($DayStart . ' +0 days'));
            $MondayArray = explode("-", $Monday);
            $MondayMonth = MonthText($MondayArray[1]);

            $list_sql = "SELECT `group`, `professor`, `SubGroup`, `name`, `StartTime`, `FinishTime`, `audience` FROM `schedule` WHERE `StartTime` LIKE '$Monday%' $where ORDER BY `StartTime`,`SubGroup`";
            $list_result = mysqli_query($conn, $list_sql);
        ?>
<a href="add.php" style="text-decoration: none"><font color="brown">Добавить</font></a>
<?php
if (isset($_GET["group"]) or isset($_GET["professor"]) or isset($_GET["a"])) {
?>

        <div class="date-container"><div class="date">понедельник, <?php echo("$MondayArray[2] $MondayMonth"); ?></div></div>
        <?php
        while ($list_row = mysqli_fetch_row($list_result)) {
            $professor_current_sql = "SELECT `name`,`position` FROM `professor` WHERE `id`=$list_row[1]";
            $professor_current_result = mysqli_query($conn, $professor_current_sql);
            $professor_current_row = mysqli_fetch_row($professor_current_result);

            $TimeStart = substr($list_row[4], 11, 5);
            $TimeFinish = substr($list_row[5], 11, 5);
        echo("
        <div class=\"list\">
            <p style=\"font-size: 25px;\">$list_row[3]</p>
            <p style=\"color:gray\">$list_row[2] подгруппа</p>
            <p style=\"color:gray\">Аудитория: $list_row[6]</p>
            <p style=\"color:gray\">Преподаватель: $professor_current_row[0], $professor_current_row[1]</p>
            <p style=\"color: orange;\">$TimeStart - $TimeFinish</p>
            <p><a href=\"edit.php?group=$list_row[0]&StartTime=$list_row[4]\" style=\"text-decoration: none;\"><font color=\"blue\" style=\"appearance: none;\">Изменить</font></a> | <font color=\"red\" style=\"cursor:pointer\" onclick=\"DeleteClick('$list_row[0]', '$list_row[4]')\">Удалить</font></p>
        </div>
        ");
        }
        ?>
        <?php
        if ($list_result->num_rows == 0)
            echo("<center>В данный момент отсутствует расписание</center>");
        ?>

        <?php
            $Tuesday = date('Y-m-d', strtotime($DayStart . ' +1 days'));
            $TuesdayArray = explode("-", $Tuesday);
            $TuesdayMonth = MonthText($TuesdayArray[1]);

            $list_sql = "SELECT `group`, `professor`, `SubGroup`, `name`, `StartTime`, `FinishTime`, `audience` FROM `schedule` WHERE `StartTime` LIKE '$Tuesday%' $where ORDER BY `StartTime`,`SubGroup`";
            $list_result = mysqli_query($conn, $list_sql);
        ?>

        <div class="date-container"><div class="date">вторник, <?php echo("$TuesdayArray[2] $TuesdayMonth"); ?></div></div>
        <?php
        while ($list_row = mysqli_fetch_row($list_result)) {
            $professor_current_sql = "SELECT `name`,`position` FROM `professor` WHERE `id`=$list_row[1]";
            $professor_current_result = mysqli_query($conn, $professor_current_sql);
            $professor_current_row = mysqli_fetch_row($professor_current_result);

            $TimeStart = substr($list_row[4], 11, 5);
            $TimeFinish = substr($list_row[5], 11, 5);
        echo("
        <div class=\"list\">
            <p style=\"font-size: 25px;\">$list_row[3]</p>
            <p style=\"color:gray\">$list_row[2] подгруппа</p>
            <p style=\"color:gray\">Аудитория: $list_row[6]</p>
            <p style=\"color:gray\">Преподаватель: $professor_current_row[0], $professor_current_row[1]</p>
            <p style=\"color: orange;\">$TimeStart - $TimeFinish</p>
            <p><a href=\"edit.php?group=$list_row[0]&StartTime=$list_row[4]\" style=\"text-decoration: none;\"><font color=\"blue\" style=\"appearance: none;\">Изменить</font></a> | <font color=\"red\" style=\"cursor:pointer\" onclick=\"DeleteClick('$list_row[0]', '$list_row[4]')\">Удалить</font></p>
        </div>
        ");
        }
        ?>
        <?php
        if ($list_result->num_rows == 0)
            echo("<center>В данный момент отсутствует расписание</center>");
        ?>

        <?php
            $Wednesday = date('Y-m-d', strtotime($DayStart . ' +2 days'));
            $WednesdayArray = explode("-", $Wednesday);
            $WednesdayMonth = MonthText($WednesdayArray[1]);

            $list_sql = "SELECT `group`, `professor`, `SubGroup`, `name`, `StartTime`, `FinishTime`, `audience` FROM `schedule` WHERE `StartTime` LIKE '$Wednesday%' $where ORDER BY `StartTime`,`SubGroup`";
            $list_result = mysqli_query($conn, $list_sql);
        ?>
        <div class="date-container"><div class="date">среда, <?php echo("$WednesdayArray[2] $WednesdayMonth"); ?></div></div>
        <?php
        while ($list_row = mysqli_fetch_row($list_result)) {
            $professor_current_sql = "SELECT `name`,`position` FROM `professor` WHERE `id`=$list_row[1]";
            $professor_current_result = mysqli_query($conn, $professor_current_sql);
            $professor_current_row = mysqli_fetch_row($professor_current_result);

            $TimeStart = substr($list_row[4], 11, 5);
            $TimeFinish = substr($list_row[5], 11, 5);
        echo("
        <div class=\"list\">
            <p style=\"font-size: 25px;\">$list_row[3]</p>
            <p style=\"color:gray\">$list_row[2] подгруппа</p>
            <p style=\"color:gray\">Аудитория: $list_row[6]</p>
            <p style=\"color:gray\">Преподаватель: $professor_current_row[0], $professor_current_row[1]</p>
            <p style=\"color: orange;\">$TimeStart - $TimeFinish</p>
            <p><a href=\"edit.php?group=$list_row[0]&StartTime=$list_row[4]\" style=\"text-decoration: none;\"><font color=\"blue\" style=\"appearance: none;\">Изменить</font></a> | <font color=\"red\" style=\"cursor:pointer\" onclick=\"DeleteClick('$list_row[0]', '$list_row[4]')\">Удалить</font></p>
        </div>
        ");
        }
        ?>
        <?php
        if ($list_result->num_rows == 0)
            echo("<center>В данный момент отсутствует расписание</center>");
        ?>

        <?php
            $Thursday = date('Y-m-d', strtotime($DayStart . ' +3 days'));
            $ThursdayArray = explode("-", $Thursday);
            $ThursdayMonth = MonthText($ThursdayArray[1]);

            $list_sql = "SELECT `group`, `professor`, `SubGroup`, `name`, `StartTime`, `FinishTime`, `audience` FROM `schedule` WHERE `StartTime` LIKE '$Thursday%' $where ORDER BY `StartTime`,`SubGroup`";
            $list_result = mysqli_query($conn, $list_sql);
        ?>

        <div class="date-container"><div class="date">четверг, <?php echo("$ThursdayArray[2] $ThursdayMonth"); ?></div></div>
        <?php
        while ($list_row = mysqli_fetch_row($list_result)) {
            $professor_current_sql = "SELECT `name`,`position` FROM `professor` WHERE `id`=$list_row[1]";
            $professor_current_result = mysqli_query($conn, $professor_current_sql);
            $professor_current_row = mysqli_fetch_row($professor_current_result);

            $TimeStart = substr($list_row[4], 11, 5);
            $TimeFinish = substr($list_row[5], 11, 5);
        echo("
        <div class=\"list\">
            <p style=\"font-size: 25px;\">$list_row[3]</p>
            <p style=\"color:gray\">$list_row[2] подгруппа</p>
            <p style=\"color:gray\">Аудитория: $list_row[6]</p>
            <p style=\"color:gray\">Преподаватель: $professor_current_row[0], $professor_current_row[1]</p>
            <p style=\"color: orange;\">$TimeStart - $TimeFinish</p>
            <p><a href=\"edit.php?group=$list_row[0]&StartTime=$list_row[4]\" style=\"text-decoration: none;\"><font color=\"blue\" style=\"appearance: none;\">Изменить</font></a> | <font color=\"red\" style=\"cursor:pointer\" onclick=\"DeleteClick('$list_row[0]', '$list_row[4]')\">Удалить</font></p>
        </div>
        ");
        }
        ?>
        <?php
        if ($list_result->num_rows == 0)
            echo("<center>В данный момент отсутствует расписание</center>");
        ?>

        <?php
            $Friday = date('Y-m-d', strtotime($DayStart . ' +4 days'));
            $FridayArray = explode("-", $Friday);
            $FridayMonth = MonthText($FridayArray[1]);

            $list_sql = "SELECT `group`, `professor`, `SubGroup`, `name`, `StartTime`, `FinishTime`, `audience` FROM `schedule` WHERE `StartTime` LIKE '$Friday%' $where ORDER BY `StartTime`,`SubGroup`";
            $list_result = mysqli_query($conn, $list_sql);
        ?>
        <div class="date-container"><div class="date">пятница, <?php echo("$FridayArray[2] $FridayMonth"); ?></div></div>
        <?php
        while ($list_row = mysqli_fetch_row($list_result)) {
            $professor_current_sql = "SELECT `name`,`position` FROM `professor` WHERE `id`=$list_row[1]";
            $professor_current_result = mysqli_query($conn, $professor_current_sql);
            $professor_current_row = mysqli_fetch_row($professor_current_result);

            $TimeStart = substr($list_row[4], 11, 5);
            $TimeFinish = substr($list_row[5], 11, 5);
        echo("
        <div class=\"list\">
            <p style=\"font-size: 25px;\">$list_row[3]</p>
            <p style=\"color:gray\">$list_row[2] подгруппа</p>
            <p style=\"color:gray\">Аудитория: $list_row[6]</p>
            <p style=\"color:gray\">Преподаватель: $professor_current_row[0], $professor_current_row[1]</p>
            <p style=\"color: orange;\">$TimeStart - $TimeFinish</p>
            <p><a href=\"edit.php?group=$list_row[0]&StartTime=$list_row[4]\" style=\"text-decoration: none;\"><font color=\"blue\" style=\"appearance: none;\">Изменить</font></a> | <font color=\"red\" style=\"cursor:pointer\" onclick=\"DeleteClick('$list_row[0]', '$list_row[4]')\">Удалить</font></p>
        </div>
        ");
        }
        ?>
        <?php
        if ($list_result->num_rows == 0)
            echo("<center>В данный момент отсутствует расписание</center>");
        ?>
        
        <?php
            $Saturday = date('Y-m-d', strtotime($DayStart . ' +5 days'));
            $SaturdayArray = explode("-", $Saturday);
            $SaturdayMonth = MonthText($SaturdayArray[1]);

            $list_sql = "SELECT `group`, `professor`, `SubGroup`, `name`, `StartTime`, `FinishTime`, `audience` FROM `schedule` WHERE `StartTime` LIKE '$Saturday%' $where ORDER BY `StartTime`,`SubGroup`";
            $list_result = mysqli_query($conn, $list_sql);
        ?>
        <div class="date-container"><div class="date">суббота, <?php echo("$SaturdayArray[2] $SaturdayMonth"); ?></div></div>
        <?php
        while ($list_row = mysqli_fetch_row($list_result)) {
            $professor_current_sql = "SELECT `name`,`position` FROM `professor` WHERE `id`=$list_row[1]";
            $professor_current_result = mysqli_query($conn, $professor_current_sql);
            $professor_current_row = mysqli_fetch_row($professor_current_result);

            $TimeStart = substr($list_row[4], 11, 5);
            $TimeFinish = substr($list_row[5], 11, 5);
        echo("
        <div class=\"list\">
            <p style=\"font-size: 25px;\">$list_row[3]</p>
            <p style=\"color:gray\">$list_row[2] подгруппа</p>
            <p style=\"color:gray\">Аудитория: $list_row[6]</p>
            <p style=\"color:gray\">Преподаватель: $professor_current_row[0], $professor_current_row[1]</p>
            <p style=\"color: orange;\">$TimeStart - $TimeFinish</p>
            <p><a href=\"edit.php?group=$list_row[0]&StartTime=$list_row[4]\" style=\"text-decoration: none;\"><font color=\"blue\" style=\"appearance: none;\">Изменить</font></a> | <font color=\"red\" style=\"cursor:pointer\" onclick=\"DeleteClick('$list_row[0]', '$list_row[4]')\">Удалить</font></p>
        </div>
        ");
        }
        ?>
        <?php
        if ($list_result->num_rows == 0)
            echo("<center>В данный момент отсутствует расписание</center>");
        ?>

        <div class="paginations">
            <a href="?<?php echo($GetPagesParameter);?>&page=<?php echo($page - 1);?>">
            <div class="pagination-date">
                <?php echo($AgoDayStartText); ?></br>
                -</br>
                <?php echo($AgoDayFinishText); ?></br>
            </div>
            </a>
            <div class="pagination-date">
                <?php echo($DayStartText); ?></br>
                -</br>
                <?php echo($DayFinishText); ?></br>
            </div>
            <a href="?<?php echo($GetPagesParameter);?>&page=<?php echo($page + 1);?>">
            <div class="pagination-date">
                <?php echo($InDayStartText); ?></br>
                -</br>
                <?php echo($InDayFinishText); ?></br>
            </div>
            </a>
        </div>
        <?php
}
        ?>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function ChooseFaculty() {
    $.ajax({
    url: "choose/faculty.php?faculty=" + $("#faculty-select").val(),
    context: document.body,
    success: function(result) {
        $("#group-select option").remove();
        $("#group-select").append(result);
    }
});
}

function ChooseGroup() {
    window.location.href = `?group=${$('#group-select').val()}`;
}

function ChooseProfessor() {
    window.location.href = `?professor=${$('#professor-select').val()}`;
}

function DeleteClick(group, start) {
    var confirmed = confirm("Вы действительно хотите удалить?");
    alert(group + " " + start);
    if (confirmed) {
        window.location.href = `action/delete.php?group=${group}&StartTime=${start}`;
    }
}
</script>
</html>