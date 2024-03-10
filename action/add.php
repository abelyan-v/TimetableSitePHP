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

    $insert_sql = "INSERT INTO `schedule`(`group`, `professor`, `SubGroup`, `name`, `StartTime`, `FinishTime`, `audience`) VALUES ('$group','$professor','$SubGroup','$SubjectName','$start','$finish','$audiency')";
    mysqli_query($conn, $insert_sql);
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
?>