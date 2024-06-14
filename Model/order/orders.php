<?php

include '../../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:../../View/webpage/home.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['feedback'])) {
    $order_id = $_POST['order_id'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];
    $dish = $_POST['dish']; // Dùng thông tin món ăn từ "your orders"
    $insert_feedback = $conn->prepare("INSERT INTO feedback (order_id, user_id, feedback, rating) VALUES (?, ?, ?, ?)");
    $insert_feedback->execute([$order_id, $user_id, $feedback, $rating]);
    $message[] = 'Feedback submitted successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../../components/css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include '../../View/user/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>orders</h3>
   <p><a href="html.php">home</a> <span> / orders</span></p>
</div>

<section class="orders">

   <h1 class="title">your orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>Number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>Address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>Payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>Your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p> Payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
      <p>Delivery status : <span style="color:<?php if($fetch_orders['delivery_status'] == 'pending'){ echo 'orange'; }else if($fetch_orders['delivery_status'] == 'shipped'){ echo 'blue'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['delivery_status']; ?></span></p>
      
      <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <input type="hidden" name="dish" value="<?= $fetch_orders['total_products']; ?>">
         <h2>Feedback</h2>
         <textarea name="feedback" id="feedback" rows="3" required></textarea>
         <label for="rating">Rating:</label>
         <select name="rating" id="rating" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
         </select>
         <button type="submit">Submit Feedback</button>
      </form>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div>

</section>

<!-- footer section starts  -->
<?php include '../../View/webpage/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../../controllers/js/script.js"></script>

</body>
</html>
