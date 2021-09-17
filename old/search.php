<?php
include('connect.php');
$stmt=$conn->prepare("SELECT * FROM users WHERE userName LIKE '%ahm%'");
$stmt->execute();
$users=$stmt->fetchAll();


foreach($users as $user){
    ?>
    <h1> <?php echo  $user['userName'] ?></h1>
    <h2> <?php echo  $user['email'] ?></h2>
    <h3> <?php echo  $user['regDate'] ?></h3>
    <?php
}
