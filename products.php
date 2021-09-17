<?php

include('header.php');

//bringing the product object from the model. model is linked in the header.php 
$productObject = new products(); //products class 
$userObject = new users();
$categoryObject = new categorys();

//creating do to store the paramteter in the url, parameter is right after ?  

if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    $do = 'select';
}

// echo $do;

if($do == 'select'){

//    echo 'welcome to select page';
    $products = $productObject->all(); //all is a function in the model
//    print_r($products);
    ?>
<!--including the table from https://datatables.net/examples/basic_init/zero_configuration.html-->
<div class="container mt-5 pt-5" >
    <a href="products.php?do=add" class="btn btn-info mb-5 text-white">Add +</a> <!--creating a link to the add page-->
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>product Name</th>
                    <th>price</th>
                    <th>salePrice</th>
                    <th>quantity</th>
                    <th>Owner ID</th>
                    <th>Owner Name</th>
                    <th>Add Date</th>
                    <!-- <th>Category</th> -->
                    <th>Category Name</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product){?> <!--looping, and the loop will populate the rows of the table a number equal to the number of $products-->
                <tr>
                    <th><?php echo $product['id']; ?></th>
                    <th><?php echo $product['productName']; ?></th> <!--populating the record-->
                    <th><?php echo $product['price']; ?></th>
                    <th><?php echo $product['salePrice']; ?></th>
                    <th><?php echo $product['quantity']; ?></th>
                    <th><?php echo $product['owner']; ?></th>
                    <?php $user = $userObject->single($product['owner']) ?>
                    <th><?php echo $user['userName']; ?></th>
                    <th><?php echo $product['addTime']; ?></th>
                    <!-- <th><?php echo $product['category']; ?></th> -->
                    <?php 
                    $category = $categoryObject->single($product['category']);
                    
                    ?>
                    <th><?php echo $category['catName']; ?></th> 
                    <th>
                        <a href="products.php?do=single&id=<?php echo $product['id'];?>" class="btn btn-info">view</a>
                        <a href="products.php?do=edit&id=<?php echo $product['id'];?>" class="btn btn-primary">edit</a>
                        <a href="products.php?do=delete&id=<?php echo $product['id'];?>" class="btn btn-danger">delete</a>

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
    $product = $productObject->single($id);
    echo '<h1 class="text-center mt-5 pt-5">'. 'Product Name: ' . $product['productName']. '</h1>';
    echo '<h1 class="text-center">'. 'price: '. $product['price']. '</h1>';
    echo '<h1 class="text-center">'. 'Sale Price: '. $product['salePrice']. '</h1>';
    echo '<h1 class="text-center">'. 'Product Number: ' .$product['owner']. '</h1>';
    $user = $userObject->single($product['owner']);
    echo '<h1 class="text-center">'. 'Customer Name: '.$user['userName']. '</h1>';
    
    
}elseif($do == 'add'){
    echo 'welcome to add page';
?>

<div class="container mt-5 pt-5">
    <!--including the form validation from bootstrap & including in the footer.php the js script to enable the validation-->
    <form class="row g-3 needs-validation" novalidate action="products.php?do=insert" method="post">
    <input type="hidden" value="<?php echo $product['id']; ?>">
      <div class="col-md-4">
        <label for="validationCustom01" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="validationCustom01" name="productName" required>
        <div class="valid-feedback">
          Looks good!
        </div>
          <div class="invalid-feedback">
            Please choose a product name.
          </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Price</label>
        <input type="text" class="form-control" id="validationCustom02" name="price" required>
        <div class="valid-feedback">
          Looks good!
        </div>
          <div class="invalid-feedback">
            Please choose a price.
          </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustomproductname" class="form-label">salePrice</label>
        <div class="input-group has-validation">
          <input type="text" class="form-control" id="validationCustomproductname" name="salePrice" aria-describedby="inputGroupPrepend" required>
          <div class="invalid-feedback">
            Please choose a sale price.
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustomproductname" class="form-label">Quantity</label>
        <div class="input-group has-validation">
          <input type="number" class="form-control" id="validationCustomproductname" name="quantity" aria-describedby="inputGroupPrepend" required>
          <div class="invalid-feedback">
            Please choose a quantity.
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustomproductname" class="form-label">Owner</label>
        <div class="input-group has-validation">
          <select class="form-control" name="owner" aria-describedby="inputGroupPrepend">
            <?php $users = $userObject->all(); //generating the users object
            foreach($users as $user){ // looping through the users to generate the ids in place of the owners. 
            ?>

            <option value="<?php echo $user['id']; ?>"><?php echo $user['userName']; ?></option>
        <?php }?>
          </select>
          <div class="invalid-feedback">
            Please choose a owner id.
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustomproductname" class="form-label">Category</label>
        <div class="input-group has-validation">
          <select class="form-control" name="category" aria-describedby="inputGroupPrepend">
            <?php $categorys = $categoryObject->all(); //generating the users object
            foreach($categorys as $category){ // looping through the users to generate the ids in place of the owners. 
              // echo $category['catName'];
            ?>

            <option value="<?php echo $category['id']; ?>"><?php echo $category['catName']; ?></option>
        <?php }?>
          </select>
          <div class="invalid-feedback">
            Please choose a owner id.
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

    $productName=$_POST['productName']; 
    $price=$_POST['price'];
    $salePrice=$_POST['salePrice'];
    $owner=$_POST['owner'];
    $quantity=$_POST['quantity'];
    $category = $_POST['category'];
    print_r($_POST);
  
     if(empty($productName)){ 
            $errors[] ='product name can not be empty';
        }
        if(empty($price)){
            $errors[] ='price can not be empty';
        }
    
        //checking the duplicate entry
        // $count = $productObject->unique("productName ='$productName'");
        // // echo $count;
        // if($count>0){
        //     $errors[] = 'productname is already registered';
        // }

        // $count = $productObject->unique("email ='$email'");
        // // echo $count;
        // if($count>0){
        //     $errors[] = 'email is already registered';
        // }

        if(isset($errors)){
            // there are errors
           foreach($errors as $error){
               echo '<p class="alert alert-danger">' . $error . '</p>';
           }
        }else{
             // no errors
            $productObject->insert("productName='$productName' , price= '$price'
                    , salePrice= '$salePrice', quantity='$quantity', owner='$owner', category = '$category'");
            // header("Refresh:3; url=products.php");

            echo '<p class="alert alert-success">product added successfully</p>';
        }
    }else {
        header('Location: products.php');
    }
    
    
}elseif($do == 'edit'){

    //geting the id from the url
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      $product = $productObject->single($id);
      ?>
      <!-- same form for the add -->
  <div class="container mt-5 pt-5">
      <!--including the form validation from bootstrap & including in the footer.php the js script to enable the validation-->
      <form class="row g-3 needs-validation" novalidate action="products.php?do=update" method="post">
        <div class="col-md-4">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>"> <!--get the id of the product and make it hidden-->
          <label for="validationCustom01" class="form-label">Name</label>
          <input type="text" class="form-control" id="validationCustom01" name="productName" value="<?php echo $product['productName']; ?>" required>
          <div class="valid-feedback">
            Looks good!
          </div>
            <div class="invalid-feedback">
              Please choose a product name.
            </div>
        </div>
        <div class="col-md-4">
          <label for="validationCustom02" class="form-label">Price</label>
          <input type="text" class="form-control" id="validationCustom02" name="price" value="<?php echo $product['price']; ?>" required>
          <div class="valid-feedback">
            Looks good!
          </div>
            <div class="invalid-feedback">
              Please choose a price.
            </div>
        </div>
        <div class="col-md-4">
          <label for="validationCustomproductname" class="form-label">Sale Price</label>
          <div class="input-group has-validation">
            <input type="text" class="form-control" name="salePrice" value="<?php echo $product['salePrice'] ?>" aria-describedby="inputGroupPrepend">
            <div class="invalid-feedback">
              Please choose a sale price.
            </div>
          </div>
        </div>
  
        <div class="col-md-4">
          <label for="validationCustomproductname" class="form-label">Quantity</label>
          <div class="input-group has-validation">
            <input type="number" class="form-control" id="validationCustomproductname" name="quantity" value="<?php echo $product['quantity']; ?>" aria-describedby="inputGroupPrepend">
            <div class="invalid-feedback">
              Please choose a quantity.
            </div>
          </div>
        </div>
  
        <div class="col-12">
          <button class="btn btn-primary" type="submit">Submit form</button>
        </div>
      </form>
  </div>
  <?php
    }else{
      header("Location: products.php");
    }
    ?>
<?php
}elseif($do == 'update'){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      print_r($_POST);
      $id=$_POST['id'];
      $productName=$_POST['productName'];
      $price=$_POST['price'];
      $salePrice=$_POST['salePrice'];
      $quantity=$_POST['quantity'];
      // print_r($_POST);
     
      if(empty($productName)){
          $errors[] ='product name can not be empty';
      }
      if(empty($price)){
          $errors[] ='email can not be empty';
      }

      //checking the duplicate entry
      // $count = $productObject->unique("productName ='$productName' AND id!=$id"); 
      // // echo $count;
      // if($count>0){
      //     $errors[] = 'productname is already registered';
      // }

      // $count = $productObject->unique("email ='$email' AND id!=$id");
      // // echo $count;
      // if($count>0){
      //     $errors[] = 'email is already registered';
      // }

      if(isset($errors)){
          // there are errors
          foreach($errors as $error){
              echo '<p class="alert alert-danger">' . $error . '</p>';
          }
      }else{
            $productObject->update(" productName='$productName', price='$price', salePrice='$salePrice', quantity='$quantity' ", $id);
          
          echo '<p class="alert alert-success"> updated successfully </p>';
      } 
      
      }else {
          header('Location: products.php');
          
      }
      
}elseif($do == 'delete'){
    // echo 'welcome to delete page';
    if(isset($_GET['id'])){
        $id= $_GET['id'];
        $productObject->delete($id);
        header('Location: products.php');
    
    }else{
        header('Location: products.php');
    }

}


include('footer.php');

?>