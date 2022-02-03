<?php
// var_dump($_POST);

$parts_1 = $_POST["parts1"];
$parts_2 = $_POST["parts2"];
$parts_3 = $_POST["parts3"];

$write_data = "{$parts_1},{$parts_2},{$parts_3}\n";

$file = fopen("csv/input.csv", "a");
flock($file, LOCK_EX);

fwrite($file, $write_data);

flock($file, LOCK_UN);

fclose($file);

header("Location:index.php");
