<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
include('connect.php');
$id=$_POST['id'];
$userName=$_POST['userName'];
$email=$_POST['email'];
if(empty($userName)){
    $errors[] ='user name can not be empty';
}
if(empty($email)){
    $errors[] ='email can not be empty';
}
if(!empty($errors)){
    // there are errors
    foreach($errors as $error){
        echo '<p style="color:red">' . $error . '</p>';
    }
}else {
    if(isset($_POST['password'])){
        $password=$_POST['password'];
        $passHash=password_hash($password,PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET  userName='$userName', email='$email'
  ,password =$passHash  WHERE id='$id' ");
        $stmt->execute();
    }else{
        $stmt = $conn->prepare("UPDATE users SET  userName='$userName', email='$email'
  WHERE id='$id' ");
        $stmt->execute();
    } // if is set password
} // errors

}else {
    header('Location: select.php');
}
