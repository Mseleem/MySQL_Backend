<?php

include('header.php');

//bringing the category object from the model. model is linked in the header.php 
$productObject = new products();
$categoryObject = new categorys(); //categorys class 

//creating do to store the paramteter in the url, parameter is right after ?  

if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    $do = 'select';
}

// echo $do;

if($do == 'select'){

   echo 'welcome to select page';
    $categorys = $categoryObject->all(); //all is a function in the model
    ?>
<!--including the table from https://datatables.net/examples/basic_init/zero_configuration.html-->
<div class="container mt-5 pt-5">
    <a href="categorys.php?do=add" class="btn btn-info mb-5 text-white">Add +</a> <!--creating a link to the add page-->
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categorys as $category){?> <!--looping, and the loop will populate the rows of the table a number equal to the number of $categorys-->
                <tr>
                    <th><?php echo $category['id']; ?></th>
                    <th><?php echo $category['catName']; ?></th> <!--populating the record-->
                    <th>
                        <a href="categorys.php?do=single&id=<?php echo $category['id'];?>" class="btn btn-info">view products</a>
                        <a href="categorys.php?do=edit&id=<?php echo $category['id'];?>" class="btn btn-primary">edit</a>
                        <a href="categorys.php?do=delete&id=<?php echo $category['id'];?>" class="btn btn-danger">delete</a>

                    </th>
                </tr>
                <?php } ?>
            </tbody>
        </table>
</div>

<?php 
}elseif($do == 'single'){
    // echo 'welcome to single page';
    
    
    $id = $_GET['id'];
    $categorys=$categoryObject->all();
    $products = $productObject->all();
    foreach($products as $product){
      if($product['category'] == $id){
      echo'<div class="mt-5 mx-auto text-center" style="width: 200px;"><h1>'.($product['productName']).'</h1></div>';
    }
  }
  


}elseif($do == 'add'){
    echo 'welcome to add page';
?>

<div class="container mt-5 pt-5">
    <!--including the form validation from bootstrap & including in the footer.php the js script to enable the validation-->
    <form class="row g-3 needs-validation" novalidate action="categorys.php?do=insert" method="post">
      <div class="col-md-4">
        <label for="validationCustom01" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="validationCustom01" name="catName" required>
        <div class="valid-feedback">
          Looks good!
        </div>
          <div class="invalid-feedback">
            Please choose a categoryname.
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
    
        $categoryName=$_POST['catName'];

        if(!isset($categoryName)){
            echo 'category name can not be empty';
        }else{
            $categoryObject->insert("catName='$categoryName'");
            // header("Refresh:3; url=categorys.php");
            echo '<p class="alert alert-success">category added successfully</p>';
        }
    
            
        
    }else {
        header('Location: categorys.php');
    }
    
    
}elseif($do == 'edit'){

    //geting the id from the url
    $id = $_GET['id'];
    $category = $categoryObject->single($id);
    ?>
    <!-- same form for the add -->
<div class="container mt-5 pt-5">
    <!--including the form validation from bootstrap & including in the footer.php the js script to enable the validation-->
    <form class="row g-3 needs-validation" novalidate action="categorys.php?do=update" method="post">


      <div class="col-md-4">
      <input type="hidden" name="id" value="<?php echo $category['id']; ?>"> <!--get the id of the category and make it hidden-->
        <label form="validationCustom01" class="form-label">Name</label>
        <input type="text" class="form-control" id="validationCustom01" name="catName" value="<?php echo $category['catName']; ?>" required>
        <div class="valid-feedback">
          Looks good!
        </div>
          <div class="invalid-feedback">
            Please choose a categoryname.
          </div>
      </div>

      <div class="col-md-4">
        <label form="validationCustom01" class="form-label">Cat Name</label>
        <select name='catName' class="form-control" id="validationCustom01">
            <?php $categorys = $categoryObject->all(); 
            foreach($categorys as $category){?>
            <option value="<?php echo $category['id']; ?>"><?php echo $category['catName']; ?></option>
            <?php } ?>
        </select>
        <div class="valid-feedback">
          Looks good!
        </div>
          <div class="invalid-feedback">
            Please choose a categoryname.
          </div>
      </div>

      <div class="col-md-4">
        <label form="validationCustom01" class="form-label">Products</label>
        <select name='productType' class="form-control" id="validationCustom01">
            <?php $products = $productObject->all(); 
            foreach($products as $product){?>
            <option value="<?php echo $product['id']; ?>"><?php echo $product['productName']; ?></option>
            <?php } ?>
        </select>
        <div class="valid-feedback">
          Looks good!
        </div>
          <div class="invalid-feedback">
            Please choose a categoryname.
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
      $categoryName=$_POST['catName'];
      $categoryObject->update(" catName='$categoryName'", $id); // the update object
      echo '<p class="alert alert-success"> updated successfully </p>';

      if(empty($categoryName)){
          $errors[] ='category name can not be empty';
      }
      if(empty($email)){
          $errors[] ='email can not be empty';
      }

      //checking the duplicate entry
      $count = $categoryObject->unique("categoryName ='$categoryName' AND id!=$id"); 
      // echo $count;
      if($count>0){
          $errors[] = 'categoryname is already registered';
      }

      $count = $categoryObject->unique("email ='$email' AND id!=$id");
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
              $categoryObject->update(" categoryName='$categoryName', email='$email' ,password =$passHash", $id);      // the update object        
          }else{
          
            $categoryObject->update(" categoryName='$categoryName', email='$email' ", $id); // the update object
          } // if is set password
          echo '<p class="alert alert-success"> updated successfully </p>';
      } // errors
      
      }else {
          header('Location: categorys.php');
      }
}elseif($do == 'delete'){
    // echo 'welcome to delete page';
    if(isset($_GET['id'])){
        $id= $_GET['id'];
        $categoryObject->delete($id);
        header('Location: categorys.php');
    
    }else{
        header('Location: categorys.php');
    }

}


include('footer.php');

?>