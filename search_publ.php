<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
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
   <title>egytop-series</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/clown.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="publishers">

   <h1 class="heading">publishers</h1>

   <form action="" method="post" class="search-publ">
      <input type="text" name="search_publisher" maxlength="100" placeholder="search publisher..." required>
      <button type="submit" name="search_publisher_btn" class="fas fa-search"></button>
   </form>

   <div class="box-container">

      <?php
         if(isset($_POST['search_publisher']) or isset($_POST['search_publisher_btn'])){
            $search_publ = $_POST['search_publisher'];
            $select_publ = $conn->prepare("SELECT * FROM `publisher` WHERE name LIKE '%{$search_publ}%'");
            $select_publ->execute();
            if($select_publ->rowCount() > 0){
               while($fetch_publis = $select_publ->fetch(PDO::FETCH_ASSOC)){

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
      ?>
      <div class="box">
         <div class="publ">
            <img src="uploaded_files/<?= $fetch_publis['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_publis['name']; ?></h3>
               <span><?= $fetch_publis['profession']; ?></span>
            </div>
         </div>
         <p>playlists : <span><?= $total_playlists; ?></span></p>
         <p>total videos : <span><?= $total_contents ?></span></p>
         <p>total likes : <span><?= $total_likes ?></span></p>
         <p>total comments : <span><?= $total_comments ?></span></p>
         <form action="publ_profile.php" method="post">
            <input type="hidden" name="publisher_email" value="<?= $fetch_publis['email']; ?>">
            <input type="submit" value="view profile" name="publisher_fetch" class="inline-btn">
         </form>
      </div>
      <?php
               }
            }else{
               echo '<p class="empty">no results found!</p>';
            }
         }else{
            echo '<p class="empty">please search something!</p>';
         }
      ?>

   </div>

</section>











<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>