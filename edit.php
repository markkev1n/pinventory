<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $ring_number = strtoupper(mysqli_real_escape_string($conn, $_POST['ring_number']));
    $pigeon_name = mysqli_real_escape_string($conn, $_POST['pigeon_name']);
    $pigeon_color = mysqli_real_escape_string($conn, $_POST['pigeon_color']);
    $bloodline = mysqli_real_escape_string($conn, $_POST['bloodline']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "UPDATE pigeons SET ring_number='$ring_number', pigeon_name='$pigeon_name', pigeon_color='$pigeon_color', bloodline='$bloodline', age='$age', gender='$gender', status='$status' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Pigeon updated successfully!";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
