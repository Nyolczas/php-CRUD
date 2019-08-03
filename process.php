<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysql_error($mysqli));
$name = "";
$location = "";
$update = false;

if(isset($_POST['save'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $position = $_POST['position'];

    $mysqli->query("INSERT INTO data (name, location, position) VALUES('$name', '$location', '$position')") or die($mysqli->error);
    
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
    $position = $_POST['position'];
    $name = $_POST['name'];
    $location = $_POST['location'];

    $sql = "UPDATE data SET name = '$name', location = '$location', position = '$position' WHERE id = $id";

    if ($mysqli->query($sql) === TRUE) {
        $_SESSION['message'] = "A frissítés megtörtént.";
        $_SESSION['msg_type'] = "warning";
        echo "Record updated successfully";
    } else {
        $_SESSION['message'] = "Hiba történt: " . $mysqli->error;
        $_SESSION['msg_type'] = "danger";
        echo "Error updating record: " . $mysqli->error;
    }

    header("location:index.php");
}
?>