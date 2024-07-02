<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>egytop-home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/clown.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- quick select section starts  -->

<section class="quick-select">

   <h1 class="heading">quick options</h1>

   <div class="box-container">

      <?php
         if($user_id != ''){
      ?>
      <div class="box">
         <h3 class="title">likes and comments</h3>
         <p>total likes : <span><?= $total_likes; ?></span></p>
         <a href="likes.php" class="inline-btn">view likes</a>
         <p>total comments : <span><?= $total_comments; ?></span></p>
         <a href="comments.php" class="inline-btn">view comments</a>
         <p>saved playlist : <span><?= $total_bookmarked; ?></span></p>
         <a href="bookmark.php" class="inline-btn">view bookmark</a>
      </div>
      <?php
         }else{ 
      ?>
      <div class="box" style="text-align: center;">
         <h3 class="title">please login or register</h3>
          <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div>
      <?php
      }
      ?>

      <div class="box">
         <h3 class="title">top categories</h3>
         <div class="flex">
            <a href="#"><i class="fa-solid fa-gun"></i><span>action</span></a>
            <a href="#"><i class="fa-solid fa-mountain"></i><span>adventure</span></a>
            <a href="#"><i class="fa-solid fa-ghost"></i><span>horror</span></a>
            <!-- <a href="#"><i class="fas fa-chart-line"></i><span></span></a> -->
            <a href="#"><i class="fas fa-music"></i><span>romantic</span></a>
            <a href="#"><i class="fas fa-camera"></i><span>thriller</span></a>
            <a href="#"><i class="fas fa-cog"></i><span>documentary</span></a>
            <a href="#"><i class="fas fa-vial"></i><span>science</span></a>
         </div>
      </div>

      <div class="box">
         <h3 class="title">popular topics</h3>
         <div class="flex">
            <a href="#"><i class=""></i><span>last of us</span></a>
            <a href="#"><i class=""></i><span>loki</span></a>
            <a href="#"><i class=""></i><span>hannibal</span></a>
            <a href="#"><i class=""></i><span>breaking bad</span></a>
            <a href="#"><i class=""></i><span>la casa de papel</span></a>
            <!-- <a href="#"><i class="fab fa-bootstrap"></i><span>bootstrap</span></a> -->
         </div>
      </div>

      <div class="box publ">
         <h3 class="title">become a publisher</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, laudantium.</p>
         <a href="admin/register.php" class="inline-btn">get started</a>
      </div>

   </div>

</section>





<section class="series">

   <h1 class="heading">latest</h1>

   <div class="box-container">

      <?php
         $select_seriess = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC LIMIT 6");
         $select_seriess->execute(['active']);
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

   <div class="more-btn">
      <a href="series.php" class="inline-option-btn">view more</a>
   </div>

</section>














<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>