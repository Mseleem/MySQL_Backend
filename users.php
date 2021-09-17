<?php

include('header.php');

//bringing the user object from the model. model is linked in the header.php 
$userObject = new users(); //users class 

//creating do to store the paramteter in the url, parameter is right after ?  

if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    $do = 'select';
}

// echo $do;

if($do == 'select'){

//    echo 'welcome to select page';
    $users = $userObject->all(); //all is a function in the model
//    print_r($users);
    ?>
<!--including the table from https://datatables.net/examples/basic_init/zero_configuration.html-->
<div class="container mt-5 pt-5">
    <a href="users.php?do=add" class="btn btn-info mb-5 text-white">Add +</a> <!--creating a link to the add page-->
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>email</th>
                    <th>registration date</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user){?> <!--looping, and the loop will populate the rows of the table a number equal to the number of $users-->
                <tr>
                    <th><?php echo $user['id']; ?></th>
                    <th><?php echo $user['userName']; ?></th> <!--populating the record-->
                    <th><?php echo $user['email']; ?></th>
                    <th><?php echo $user['regDate']; ?></th>
                    <th>
                        <a href="users.php?do=single&id=<?php echo $user['id'];?>" class="btn btn-info">view</a>
                        <a href="users.php?do=edit&id=<?php echo $user['id'];?>" class="btn btn-primary">edit</a>
                        <a href="users.php?do=delete&id=<?php echo $user['id'];?>" class="btn btn-danger">delete</a>

                    </th>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>email</th>
                    <th>registration date</th>
                    <th>actions</th>
                </tr>
            </tfoot>
        </table>
</div>

<?php 
}elseif($do == 'single'){
    // echo 'welcome to single page';
    $id = $_GET['id'];
    $user = $userObject->single($id);
    echo '<h1 class="text-center mt-5 pt-5">'. $user['userName']. '</h1>';
    echo '<h1 class="text-center mt-5 pt-5">'. $user['email']. '</h1>';
    echo '<h1 class="text-center mt-5 pt-5">'. $user['regDate']. '</h1>';
    
    
}elseif($do == 'add'){
    echo 'welcome to add page';
?>

<div class="container mt-5 pt-5">
    <!--including the form validation from bootstrap & including in the footer.php the js script to enable the validation-->
    <form class="row g-3 needs-validation" novalidate action="users.php?do=insert" method="post">
      <div class="col-md-4">
        <label for="validationCustom01" class="form-label">Name</label>
        <input type="text" class="form-control" id="validationCustom01" name="userName" required>
        <div class="valid-feedback">
          Looks good!
        </div>
          <div class="invalid-feedback">
            Please choose a username.
          </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Email</label>
        <input type="email" class="form-control" id="validationCustom02" name="email" required>
        <div class="valid-feedback">
          Looks good!
        </div>
          <div class="invalid-feedback">
            Please choose a username.
          </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustomUsername" class="form-label">Password</label>
        <div class="input-group has-validation">
          <input type="password" class="form-control" id="validationCustomUsername" name="password" aria-describedby="inputGroupPrepend" required>
          <div class="invalid-feedback">
            Please choose a username.
          </div>
        </div>
      </div>

      <div class="col-12">
        <button class="btn btn-primary" type="submit">Submit form</button>
      </div>
    </form>
</div>

<?php
}elseif($do == 'insert'){
//    echo 'welcome to insert page';  
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
//    include('connect.php'); //connect.php is included 
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

        //checking the duplicate entry
        $count = $userObject->unique("userName ='$userName'");
        // echo $count;
        if($count>0){
            $errors[] = 'username is already registered';
        }

        $count = $userObject->unique("email ='$email'");
        // echo $count;
        if($count>0){
            $errors[] = 'email is already registered';
        }

        if(isset($errors)){
            // there are errors
           foreach($errors as $error){
               echo '<p class="alert alert-danger">' . $error . '</p>';
           }
        }else{
             // no errors
            $userObject->insert("userName='$userName' , email= '$email'
                    , password= '$passHash'");
            header("Refresh:3; url=users.php");

            echo '<p class="alert alert-success">user added successfully</p>';
        }
    }else {
        header('Location: users.php');
    }
    
    
}elseif($do == 'edit'){

    //geting the id from the url
    $id = $_GET['id'];
    $user = $userObject->single($id);
    ?>
    <!-- same form for the add -->
<div class="container mt-5 pt-5">
    <!--including the form validation from bootstrap & including in the footer.php the js script to enable the validation-->
    <form class="row g-3 needs-validation" novalidate action="users.php?do=update" method="post">
      <div class="col-md-4">
      <input type="hidden" name="id" value="<?php echo $user['id']; ?>"> <!--get the id of the user and make it hidden-->
        <label for="validationCustom01" class="form-label">Name</label>
        <input type="text" class="form-control" id="validationCustom01" name="userName" value="<?php echo $user['userName']; ?>" required>
        <div class="valid-feedback">
          Looks good!
        </div>
          <div class="invalid-feedback">
            Please choose a username.
          </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Email</label>
        <input type="email" class="form-control" id="validationCustom02" name="email" value="<?php echo $user['email']; ?>" required>
        <div class="valid-feedback">
          Looks good!
        </div>
          <div class="invalid-feedback">
            Please choose a username.
          </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustomUsername" class="form-label">Password</label>
        <div class="input-group has-validation">
          <input type="password" class="form-control" id="validationCustomUsername" name="password" aria-describedby="inputGroupPrepend">
          <div class="invalid-feedback">
            Please choose a username.
          </div>
        </div>
      </div>

      <div class="col-12">
        <button class="btn btn-primary" type="submit">Submit form</button>
      </div>
    </form>
</div>

<?php
}elseif($do == 'update'){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      // print_r($_POST);
      $id=$_POST['id'];
      $userName=$_POST['userName'];
      $email=$_POST['email'];
      if(empty($userName)){
          $errors[] ='user name can not be empty';
      }
      if(empty($email)){
          $errors[] ='email can not be empty';
      }

      //checking the duplicate entry
      $count = $userObject->unique("userName ='$userName' AND id!=$id"); 
      // echo $count;
      if($count>0){
          $errors[] = 'username is already registered';
      }

      $count = $userObject->unique("email ='$email' AND id!=$id");
      // echo $count;
      if($count>0){
          $errors[] = 'email is already registered';
      }

      if(isset($errors)){
          // there are errors
          foreach($errors as $error){
              echo '<p class="alert alert-danger">' . $error . '</p>';
          }
      }else {
          if(!empty($_POST['password'])){
              $password=$_POST['password'];
              $passHash=password_hash($password,PASSWORD_BCRYPT);
              $userObject->update(" userName='$userName', email='$email' ,password =$passHash", $id);      // the update object        
          }else{
          
            $userObject->update(" userName='$userName', email='$email' ", $id); // the update object
          } // if is set password
          echo '<p class="alert alert-success"> updated successfully </p>';
      } // errors
      
      }else {
          header('Location: users.php');
      }
}elseif($do == 'delete'){
    // echo 'welcome to delete page';
    if(isset($_GET['id'])){
        $id= $_GET['id'];
        $userObject->delete($id);
        header('Location: users.php');
    
    }else{
        header('Location: users.php');
    }

}


include('footer.php');

?>