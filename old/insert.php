<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
include('connect.php');
$userName=$_POST['userName'];
$email=$_POST['email'];
$password=$_POST['password'];
    $passHash=password_hash($password,PASSWORD_BCRYPT);

 if(empty($userName)){
        $errors[] ='user name can not be empty';
    }
    if(empty($email)){
        $errors[] ='email can not be empty';
    }
    if(empty($password)){
        $errors[] ='password can not be empty';
    }
    if(isset($errors)){
        // there are errors
       foreach($errors as $error){
           echo '<p style="color:red">' . $error . '</p>';
       }
    }else{
         // no errors
        $stmt=$conn->prepare("INSERT INTO users SET userName='$userName' , email= '$email'
                , password= '$passHash'");
        $stmt->execute();
        header("Refresh:3; url=select.php");

        echo 'user added successfully';
    }
}else {
    header('Location: select.php');
}