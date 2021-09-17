<?php
include('connect.php');
if(isset($_GET['id'])){
    $id= $_GET['id'];
    $stmt=$conn->prepare("SELECT * FROM users WHERE id='$id'");
    $stmt->execute();
    $user=$stmt->fetch();
    ?>
    <style>
        label,input,button{
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 15px 15px 15px 0;
        }
        button{
            background-color: red;
            color:white;
            border: none;
            box-shadow: none;
            font-weight: bold;
        }

    </style>
    <form method="post" action="update.php">
        <input type="hidden" name="id" value="<?Php echo $user['id'];?>">
        <label>User Name</label>
        <input type="text" name="userName" value="<?Php echo $user['userName'];?>">
        <label>Email</label>
        <input type="email" name="email" value="<?Php echo $user['email'];?>">
        <label>Password</label>
        <input type="password" name="password">

        <button type="submit">submit</button>
    </form>

<?php
}else{
    header('Location: select.php');
}