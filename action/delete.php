<?php
    $group = $_GET["group"];
    $StartTime = $_GET["StartTime"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schedule";
    $conn = new mysqli($servername, $username, $password, $dbname);

    $delete_sql = "DELETE FROM `schedule` WHERE `group` = '$group' AND `StartTime` = '$StartTime'";
    mysqli_query($conn, $delete_sql);
    echo("$group | $StartTime");
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
?>