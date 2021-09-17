<?php
if(isset($_GET['id'])){
    include('connect.php');
    $id= $_GET['id'];
        $stmt=$conn->prepare("DELETE FROM users WHERE id='$id'");
    $stmt->execute();
    header('Location: select.php');

}else{
    header('Location: select.php');
}