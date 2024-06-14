<?php

include '../../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../admin/admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:../admin/messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../../components/css/admin_style.css">

</head>
<body>

<?php include '../../View/admin/admin_header.php' ?>

<!-- messages section starts  -->

<section class="messages">

   <h1 class="heading">messages</h1>

   <div class="box-container">

   <?php
      // Fetch messages
      $select_messages = $conn->prepare("SELECT * FROM `messages`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> name : <span><?= $fetch_messages['name']; ?></span> </p>
      <p> number : <span><?= $fetch_messages['number']; ?></span> </p>
      <p> email : <span><?= $fetch_messages['email']; ?></span> </p>
      <p> message : <span><?= $fetch_messages['message']; ?></span> </p>
      <a href="../admin/messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('delete this message?');">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">you have no messages</p>';
      }

      // Fetch feedback
      $select_feedback = $conn->prepare("SELECT * FROM `feedback`");
      $select_feedback->execute();
      if($select_feedback->rowCount() > 0){
         while($fetch_feedback = $select_feedback->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> User ID : <span><?= $fetch_feedback['user_id']; ?></span> </p>
      <p> Order ID : <span><?= $fetch_feedback['order_id']; ?></span> </p>
      <p> Feedback : <span><?= $fetch_feedback['feedback']; ?></span> </p>
      <a href="../admin/messages.php?delete_feedback=<?= $fetch_feedback['id']; ?>" class="delete-btn" onclick="return confirm('delete this feedback?');">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">you have no feedback</p>';
      }

      // Handle feedback deletion
      if(isset($_GET['delete_feedback'])){
         $delete_feedback_id = $_GET['delete_feedback'];
         $delete_feedback = $conn->prepare("DELETE FROM `feedback` WHERE id = ?");
         $delete_feedback->execute([$delete_feedback_id]);
         header('location:../admin/messages.php');
      }
   ?>

   </div>

</section>

<!-- messages section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
