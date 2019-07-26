<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysql_error($mysqli));
$name = "";
$location = "";
$update = false;

if(isset($_POST['save'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];

    $mysqli->query("INSERT INTO data (name, location) VALUES('$name', '$location')") or die($mysqli->error);
    
    $_SESSION['message'] = "Sikeres mentés.";
    $_SESSION['msg_type'] = "success";
    
    header("location:index.php");
}

if(isset($_GET['delete'])) {
    
    $id = $_GET['delete'];

    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());
    
    $_SESSION['message'] = "Törölve.";
    $_SESSION['msg_type'] = "danger";
    
    header("location:index.php");
}

if(isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());

    $row = $result->fetch_array();
    $name = $row['name'];
    $location = $row['location'];
}

if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];

    $mysqli->query("UPDATE data SET name = '$name', location = '$location' WHERE id = $id") or die($mysqli->error);

    $_SESSION['message'] = "A frissítés megtörtént.";
    $_SESSION['msg_type'] = "warning";
    
    header("location:index.php");
}
?>