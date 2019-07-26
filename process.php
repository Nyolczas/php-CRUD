<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysql_error($mysqli));

if(isset($_POST['save'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];

    $mysqli->query("INSERT INTO data (name, location) VALUES('$name', '$location')") or die($mysqli->error);
    header("location:index.php");

}

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());
    header("location:index.php");

}


?>