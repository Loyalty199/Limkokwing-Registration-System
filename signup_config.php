<?php

include "connect.php";
// include "function.php"; 

if (isset($_POST['submit'])) {
    $errors = [];

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }

    if (strlen($_POST["password"]) < 8) {
        $errors[] = "Password must contain at least 8 characters";
    }

    if (!preg_match("/[a-z]/", $_POST["password"])) {
        $errors[] = "Password must contain at least one letter";
    }

    if (!preg_match("/[0-9]/", $_POST["password"])) {
        $errors[] = "Password must contain at least one number";
    }

    if ($_POST["password"] !== $_POST["compass"]) {
        $errors[] = "Passwords must match";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error'); window.location.href='signup.php';</script>";
        }
    } else {
        $email = $_POST['email'];
        $fname = $_POST['name'];
        $birth = $_POST['birth'];
        $falstudylec = $_POST['falstudylec'];
        $studentidleccode = $_POST['studentidleccode'];
        $pstudylec = $_POST['pstudylec'];
        $semstudylec = $_POST['semstudylec'];
        $password = $_POST['password'];
        $compass = $_POST['compass'];
        $regas = $_POST['regas'];

        $sql = "INSERT INTO studentreg (email, fname, birth, falstudylec, stuidleccode, pstudylec, semstudylec, password, compass, regas) VALUES ('$email', '$fname', '$birth', '$falstudylec', '$studentidleccode', '$pstudylec', '$semstudylec', '$password', '$compass', '$regas')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Registration successful'); window.location.href='login.php';</script>";
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
    }
}
?>