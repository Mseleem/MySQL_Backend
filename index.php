<?php
session_start();
if(isset($_SESSION['login'])){ //directing logged users away from the login 
    header ("Location: dashboard.php");
}
include('model.php');
$userObject=new users();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $count=$userObject->unique("email='$email'");
   if($count > 0){ // mail is in database
       $user=$userObject->whereSingle("email='$email'");
       if(password_verify($password,$user['password'])){ // right password
           $msg='<p class="alert alert-success">right password</p>';
           $_SESSION['login'] = $email; 
           $_SESSION['role'] = $user['userGroup'];
           header("Location: dashboard.php");
       }else{ // wrong password
           $msg='<p class="alert alert-danger">Email Or Password is wrong</p>';
       }
    }else{ // mail not found in database
       $msg='<p class="alert alert-danger">Email Or Password is wrong</p>';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Login Page</title>
</head>
<body>
<div class="container mt-5 pt-5">

<form class="row g-3 needs-validation w-50 mx-auto text-center" method="post" novalidate>
    <?php
    if(isset($msg)){
     echo $msg;
    }
    ?>
    <div class="col-md-12">
        <label for="validationCustom01" class="form-label">Email</label>
        <input type="email" class="form-control" id="validationCustom01" name="email" required>
        <div class="valid-feedback">
            Looks good!
        </div>
        <div class="invalid-feedback">
            enter a valid mail form
        </div>
    </div>
    <div class="col-md-12">
        <label for="validationCustom02" class="form-label">Password</label>
        <input type="password" class="form-control" id="validationCustom02" name="password"  required>
        <div class="valid-feedback">
            Looks good!
        </div>
        <div class="invalid-feedback">
           password can not be empty
        </div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary" type="submit">Submit form</button>
    </div>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
</body>
</html>