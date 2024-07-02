<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['publisher_fetch'])){

   $publ_email = $_POST['publisher_email'];
   $publ_email = filter_var($publ_email, FILTER_SANITIZE_STRING);
   $select_publis = $conn->prepare('SELECT * FROM `publisher` WHERE email = ?');
   $select_publis->execute([$publ_email]);

   $fetch_publis = $select_publis->fetch(PDO::FETCH_ASSOC);
   $publ_id = $fetch_publis['id'];

   $count_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE publisher_id = ?");
   $count_playlists->execute([$publ_id]);
   $total_playlists = $count_playlists->rowCount();

   $count_contents = $conn->prepare("SELECT * FROM `content` WHERE publisher_id = ?");
   $count_contents->execute([$publ_id]);
   $total_contents = $count_contents->rowCount();

   $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE publisher_id = ?");
   $count_likes->execute([$publ_id]);
   $total_likes = $count_likes->rowCount();

   $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE publisher_id = ?");
   $count_comments->execute([$publ_id]);
   $total_comments = $count_comments->rowCount();

}else{
   header('location:publishers.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>egytop-profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/clown.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>



<section class="publ-profile">

   <h1 class="heading">profile details</h1>

   <div class="details">
      <div class="publi">
         <img src="uploaded_files/<?= $fetch_publis['image']; ?>" alt="">
         <h3><?= $fetch_publis['name']; ?></h3>
         <span><?= $fetch_publis['profession']; ?></span>
      </div>
      <div class="flex">
         <p>total playlists : <span><?= $total_playlists; ?></span></p>
         <p>total videos : <span><?= $total_contents; ?></span></p>
         <p>total likes : <span><?= $total_likes; ?></span></p>
         <p>total comments : <span><?= $total_comments; ?></span></p>
      </div>
   </div>

</section>



<section class="series">

   <h1 class="heading">latest series</h1>

   <div class="box-container">

      <?php
         $select_seriess = $conn->prepare("SELECT * FROM `playlist` WHERE publisher_id = ? AND status = ?");
         $select_seriess->execute([$publ_id, 'active']);
         if($select_seriess->rowCount() > 0){
            while($fetch_series = $select_seriess->fetch(PDO::FETCH_ASSOC)){
               $series_id = $fetch_series['id'];

               $select_publis = $conn->prepare("SELECT * FROM `publisher` WHERE id = ?");
               $select_publis->execute([$fetch_series['publisher_id']]);
               $fetch_publis = $select_publis->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box">
         <div class="publis">
            <img src="uploaded_files/<?= $fetch_publis['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_publis['name']; ?></h3>
               <span><?= $fetch_series['date']; ?></span>
            </div>
         </div>
         <img src="uploaded_files/<?= $fetch_series['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_series['title']; ?></h3>
         <a href="playlist.php?get_id=<?= $series_id; ?>" class="inline-btn">view playlist</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no series added yet!</p>';
      }
      ?>

   </div>

</section>












<?php include 'components/footer.php'; ?>    

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>