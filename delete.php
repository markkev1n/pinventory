<?php
include 'db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM pigeons WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}
mysqli_close($conn);
?>
