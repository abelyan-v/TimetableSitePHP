<?php
    $group = $_POST["group"];
    $professor = $_POST["professor"];
    $SubGroup = $_POST["SubGroup"];
    $SubjectName = $_POST["subject-name"];
    $start = $_POST["start"];
    $finish = $_POST["finish"];
    $audiency = $_POST["audiency"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schedule";
    $conn = new mysqli($servername, $username, $password, $dbname);
    echo("debug: group is $group | professor is $professor | subgroup is $SubGroup | subject name is $SubjectName | start time is $start | finish time is $finish | audiency is $audiency");

    $update_sql = "UPDATE `schedule` SET `group`='$group',`professor`=$professor,`SubGroup`=$SubGroup,`name`='$SubjectName',`StartTime`='$start',`FinishTime`='$finish',`audience`='$audiency' WHERE `group` = '$group' AND `StartTime` = '$start'";
    mysqli_query($conn, $update_sql);
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
?>