<?php

include 'components/connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>egytop-watch</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/surprise.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
<section class="watch-video">
      <div class="video-container">
        <div class="video">
          <video
            src="images/clown.mp4"
            controls
            autoplay
            id="video"
            
          ></video>
        </div>
       









<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>