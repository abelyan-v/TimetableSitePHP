<?php
$fac_id = $_GET['faculty'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schedule";
$conn = new mysqli($servername, $username, $password, $dbname);

$group_sql = "SELECT `number`, `name` FROM `group` WHERE `faculty` = $fac_id";
$group_result = mysqli_query($conn, $group_sql);

echo("<option>Выберите группу</option>");
while ($row = mysqli_fetch_row($group_result)) {
    echo("<option value=\"$row[0]\">$row[1]</option>");
}
?>