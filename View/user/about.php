<?php

include '../../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

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
   <h3>about us</h3>
   <p><a href="../webpage/home.php">Home</a> <span> / About</span></p>
</div>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="../../components/images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Visit our restaurant to experience the welcoming ambiance and delicious flavors of a wide variety of dishes. Here, we take pride in serving carefully crafted meals made with the freshest ingredients, guaranteed to please even the pickiest eaters. Start your amazing culinary adventures right now!</p>
         <a href="../user/menu.php" class="btn">Our menu</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- steps section starts  -->

<section class="steps">

   <h1 class="title">simple steps</h1>

   <div class="box-container">

      <div class="box">
         <img src="../../components/images/step-1.png" alt="">
         <h3>choose order</h3>
         <p></p>
      </div>

      <div class="box">
         <img src="../../components/images/step-2.png" alt="">
         <h3>Fast delivery</h3>
         <p></p>
      </div>

      <div class="box">
         <img src="../../components/images/step-3.png" alt="">
         <h3>Enjoy food</h3>
         <p></p>
      </div>

   </div>

</section>

<!-- steps section ends -->

<!-- reviews section starts  -->

<section class="reviews">

   <h1 class="title">Customer's reviews</h1>

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">

         <?php
         $select_reviews = $conn->prepare("SELECT r.*, u.name FROM `reviews` r JOIN `users` u ON r.user_id = u.id ORDER BY r.created_at DESC");
         $select_reviews->execute();
         if($select_reviews->rowCount() > 0){
            while($fetch_reviews = $select_reviews->fetch(PDO::FETCH_ASSOC)){
         ?>
         <div class="swiper-slide slide">
            <img src="../../components/images/pic-1.png" alt="">
            <p><?= $fetch_reviews['feedback']; ?></p>
            <div class="stars">
               <?php for($i=0; $i<5; $i++): ?>
                  <i class="fas fa-star<?= $i < $fetch_reviews['rating'] ? '' : '-half-alt'; ?>"></i>
               <?php endfor; ?>
            </div>
            <h3><?= $fetch_reviews['name']; ?></h3>
         </div>
         <?php
            }
         } else {
            echo '<p class="empty">No reviews yet!</p>';
         }
         ?>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<!-- reviews section ends -->

<!-- footer section starts  -->
<?php include '../webpage/footer.php'; ?>
<!-- footer section ends -->

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="../../controllers/js/script.js"></script>

<script>
var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 1,
      },
      700: {
         slidesPerView: 2,
      },
      1024: {
         slidesPerView: 3,
      },
   },
});
</script>

</body>
</html>
