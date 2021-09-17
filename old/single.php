<?php
include('connect.php');
if(isset($_GET['id'])){
$id= $_GET['id'];
$stmt=$conn->prepare("SELECT * FROM users WHERE id='$id'");
$stmt->execute();
$user=$stmt->fetch();
echo $user['userName'] . '<br> ';
echo $user['email'] . '<br> ';
echo $user['password'] . '<br> ';

}else{
    header('Location: select.php');
}