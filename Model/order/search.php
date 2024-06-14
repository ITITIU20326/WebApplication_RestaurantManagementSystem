<?php

include '../../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include '../product/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../../components/css/style.css">

   <style>
      .suggestions {
         position: absolute;
         background: #fff;
         border: 1px solid #ddd;
         max-height: 300px;
         overflow-y: auto;
         width: 100%;
         z-index: 1000;
      }
      .suggestion-item {
         display: flex;
         align-items: center;
         padding: 10px;
         border-bottom: 1px solid #ddd;
         cursor: pointer;
      }
      .suggestion-item img {
         width: 50px;
         height: 50px;
         object-fit: cover;
         margin-right: 10px;
         border-radius: 50%;
      }
      .suggestion-item span {
         flex-grow: 1;
      }
      .suggestion-item:last-child {
         border-bottom: none;
      }
      .products-container {
         display: flex;
         flex-wrap: wrap;
         justify-content: space-between;
         margin-top: 20px;
      }
      .product-box {
         width: calc(25% - 20px);
         margin-bottom: 20px;
         padding: 10px;
         border: 1px solid #ddd;
         border-radius: 5px;
         text-align: center;
      }
      .product-box img {
         width: 100%;
         height: 150px;
         object-fit: cover;
         margin-bottom: 10px;
         border-radius: 5px;
         cursor: pointer;
      }
   </style>

</head>
<body>
   
<!-- header section starts  -->
<?php include '../../View/user/user_header.php'; ?>
<!-- header section ends -->


<!-- search form section starts  -->

<section class="search-form">
   <form id="search-form" method="post" action="">
      <input type="text" id="search-box" name="search_box" placeholder="search here..." class="box">
      <button type="submit" name="search_btn" class="fas fa-search"></button>
   </form>
   <div class="suggestions" id="suggestions"></div>
</section>

<!-- search form section ends -->

<!-- Product list section starts -->
<section class="products">
<div class="box-container">

<?php
   $select_products = $conn->prepare("SELECT * FROM `products`");
   $select_products->execute();
   if($select_products->rowCount() > 0){
      while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
?>
<form action="" method="post" class="box">
   <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
   <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
   <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
   <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
   <a href="../webpage/quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
   <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
   <img src="../../components/uploaded_img/<?= $fetch_products['image']; ?>" alt="">
   <a href="../user/category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
   <div class="name"><?= $fetch_products['name']; ?></div>
   <div class="flex">
      <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
      <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
   </div>
</form>
<?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
?>

</div>
</section>
<!-- Product list section ends -->

<!-- footer section starts  -->
<?php include '../../View/webpage/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../../controllers/js/script.js"></script>

<script>
document.getElementById('search-box').addEventListener('input', function() {
   let query = this.value;
   if (query.length > 2) {
      let xhr = new XMLHttpRequest();
      xhr.open('POST', 'search_suggestions.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
         if (this.status == 200) {
            document.getElementById('suggestions').innerHTML = this.responseText;
         }
      };
      xhr.send('query=' + query);
   } else {
      document.getElementById('suggestions').innerHTML = '';
   }
});

document.addEventListener('click', function(e) {
   if (!e.target.closest('.suggestions') && !e.target.closest('#search-box')) {
      document.getElementById('suggestions').innerHTML = '';
   }
});

function displayProductDetails(productId) {
   let xhr = new XMLHttpRequest();
   xhr.open('POST', 'get_product_details.php', true);
   xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
   xhr.onload = function() {
      if (this.status == 200) {
         document.getElementById('product-list').innerHTML = this.responseText;
      }
   };
   xhr.send('product_id=' + productId);
}
</script>

</body>
</html>
