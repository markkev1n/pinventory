<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ring_number = strtoupper(mysqli_real_escape_string($conn, $_POST['ring_number']));
    $pigeon_name = mysqli_real_escape_string($conn, $_POST['pigeon_name']);
    $pigeon_color = mysqli_real_escape_string($conn, $_POST['pigeon_color']);
    $bloodline = mysqli_real_escape_string($conn, $_POST['bloodline']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "INSERT INTO pigeons (ring_number, pigeon_name, pigeon_color, bloodline, age, gender, status) 
            VALUES ('$ring_number', '$pigeon_name', '$pigeon_color', '$bloodline', '$age', '$gender', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "Pigeon added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
