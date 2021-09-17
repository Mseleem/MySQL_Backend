<a href="add.php">Add</a>
<?php
include('connect.php');
$stmt=$conn->prepare("SELECT * FROM users");
$stmt->execute();
$users=$stmt->fetchAll();
/* echo '<pre>';
print_r($users);
echo '</pre>';
 */

foreach($users as $user){
    echo $user['userName'] . '<br> ';
    echo $user['email'] . '<br> ';
    echo $user['password'] . '<br> ';
    ?>
    <a href="single.php?id=<?php echo $user['id']; ?>">View</a>
    <a href="edit.php?id=<?php echo $user['id']; ?>">Edit</a>
    <a href="delete.php?id=<?php echo $user['id']; ?>">Delete</a>
<?php
}