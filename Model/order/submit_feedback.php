<?php
include '../../components/connect.php';
session_start();

if(isset($_POST['order_id']) && isset($_POST['feedback']) && isset($_SESSION['user_id'])){
    $order_id = $_POST['order_id'];
    $feedback = $_POST['feedback'];
    $user_id = $_SESSION['user_id'];

    $insert_feedback = $conn->prepare("INSERT INTO `reviews` (order_id, user_id, feedback, rating) VALUES (?, ?, ?, ?)");
    $insert_feedback->execute([$order_id, $user_id, $feedback, 5]); // Assuming a fixed rating of 5 for simplicity

    header('location:../../Model/order/order.php');
} else {
    header('location:../../View/webpage/home.php');
}
?>
