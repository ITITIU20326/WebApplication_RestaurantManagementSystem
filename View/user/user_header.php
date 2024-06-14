<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .restaurant-icon {
            font-size: 100px;
            color: #ff6347; /* Màu đỏ cà chua */
        }
        .restaurant-name {
            font-family: 'Arial', sans-serif;
            font-size: 24px;
            color: #333;
            margin-top: 10px;
        }
        .icon-container {
            text-align: center;
            margin-top: 50px;
        }
    </style>

      <div class="icon-container">
        <i class="fas fa-utensils restaurant-icon"></i>
        <a href="../../View/webpage/home.php" class="logo">  Minnie </a>
      </div>

      <nav class="navbar">
         <a href="../../View/webpage/home.php">Home</a>
         <a href="../../View/user/about.php">About</a>
         <a href="../../View/user/menu.php">Menu</a>
         <a href="../../Model/order/orders.php">Orders</a>
         <a href="../../View/user/contact.php">Contact</a>
      </nav>

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="../../Model/order/search.php"><i class="fas fa-search"></i></a>
         <a href="../../Model/product/cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="../../View/user/profile.php" class="btn">profile</a>
            <a href="../../View/user/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>
         <p class="account">
            <a href="../../View/user/login.php">Login</a> or
            <a href="../../View/user/register.php">Register</a>
         </p> 
         <?php
            }else{
         ?>
            <p class="name">Please login first!</p>
            <a href="../../View/user/login.php" class="btn">Login</a>
         <?php
          }
         ?>
      </div>

   </section>

</header>

