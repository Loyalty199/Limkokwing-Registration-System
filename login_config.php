<?php

include("connect.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM studentreg WHERE email = '$email' and password = '$password'";
    $result = mysqli_query($conn, $query);
    if($result){
        $data = mysqli_fetch_assoc($result);
        if ($password == $data["password"]){
            $_SESSION["id"] = $data['id'];
            echo "<script>alert('Login Successful'); window.location.href='index.php';</script>";
            die();
        }else {
            // password is incorrect
            echo"<script>alert('wrong email or password'); </script>";
        } 
    }  else {
        // user not found
        echo"<script>alert(Wrong email or password);</script>";

}
}


?>