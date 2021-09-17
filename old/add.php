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
<form method="post" action="insert.php">
    <label>User Name</label>
    <input type="text" name="userName">
    <label>Email</label>
    <input type="email" name="email">
    <label>Password</label>
    <input type="password" name="password">

    <button type="submit">submit</button>
</form>

<?php
/*
echo '<pre>';
print_r($_GET);
echo '</pre>';


echo '<pre>';
print_r($_POST);
echo '</pre>';

*/