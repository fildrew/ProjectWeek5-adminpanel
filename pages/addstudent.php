<?php 
    include 'config.php';
    if(isset($_POST['submit'])){
        
        $image = $_FILES['img']['name'];
        $tempname = $_FILES['img']['tmp_name'];  
        $folder = "../assets/img/".$image;
        
        if(move_uploaded_file($tempname,$folder)){
            echo 'images est uplade';
        }

        $Name = $_POST['Name'];
        $Email = $_POST['Email'];
        $Phone = $_POST['Phone'];
        $EnrollNumber = $_POST['EnrollNumber'];
        $DateOfAdmission = $_POST['DateOfAdmission'];

        $request = $con->prepare("INSERT INTO students_list(img,Name,Email,Phone,EnrollNumber,DateOfAdmission) VALUES('$image','$Name','$Email','$Phone','$EnrollNumber','$DateOfAdmission')");
        $request->execute();
    }
    header('location:students_list.php')
    ?>