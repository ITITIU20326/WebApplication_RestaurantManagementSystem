<?php

include '../../components/connect.php';

if(isset($_POST['query'])) {
   $query = $_POST['query'];
   $stmt = $conn->prepare("SELECT * FROM `products` WHERE name LIKE ?");
   $stmt->execute(['%' . $query . '%']);
   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   if ($stmt->rowCount() > 0) {
      foreach ($results as $row) {
         echo '<div class="suggestion-item" onclick="selectSuggestion(\'' . $row['name'] . '\')">';
         echo '<img src="../../components/uploaded_img/' . $row['image'] . '" alt="' . $row['name'] . '">';
         echo '<span>' . $row['name'] . '</span>';
         echo '</div>';
      }
   } else {
      echo '<p class="empty">No results found</p>';
   }
}
?>

<script>
function selectSuggestion(name) {
   document.getElementById('search-box').value = name;
   document.getElementById('suggestions').innerHTML = '';
}
</script>
