<?php
include('../components/connect.php');

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_category'])){
  $category_title=$_POST['cat_title'];
  $category_title = filter_var( $category_title, FILTER_SANITIZE_STRING);

  //select data from database
  $select_products = $conn->prepare("SELECT * FROM `categories` WHERE cat_title = ?");
$select_products->execute([$category_title]);
   
   if($select_products->rowCount() > 0){
    $message[] = 'Category already exists!';
}
 else{ 
  $insert_product = $conn->prepare("INSERT INTO `categories`(cat_title) VALUES(?)");
  $insert_product->execute([$category_title]);
  $message[] = 'New Category added!';
 }
}
?>
<?php include '../components/admin_header.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<section class="add-products">

<form action="" method="post" class="mb-2">
<h2 class="text-center">Insert Categories</h2>
    
     <input type="text" required placeholder="enter new category" name="cat_title" maxlength="100" class="box">
     <input type="submit" value="add category" name="add_category" class="btn">
   </div>
</form>

<section class="show-products" style="padding-top: 10;">

   <div class="box-container">

   <?php
      $show_cat = $conn->prepare("SELECT * FROM `categories`");
      $show_cat->execute();
      if($show_cat->rowCount() > 0){
         while($fetch_cat = $show_cat->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <div class="flex">
         <div class="category"><?= $fetch_cat['cat_title']; ?></div>
      </div>

   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no Categories added yet!</p>';
      }
   ?>

</body>
</html>