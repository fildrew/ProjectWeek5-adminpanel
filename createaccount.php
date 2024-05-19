<?php
    if(isset($_POST['submit'])){
        include './pages/config.php';
        $userName = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $conPass = $_POST['conPass'];
        if($pass === $conPass){
            var_dump($userName);
            $request = $con->prepare("INSERT INTO users(username,Email,Password)
             VALUES('$userName','$email','$pass')");
            $request->execute();
            header('location:index.php');
        }
        else{
            header("location:index.php?error=password not found");
        }
    }
?>