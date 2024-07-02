<?php

   include 'connect.php';

   setcookie('publisher_id', '', time() - 1, '/');

   header('location:../home.php');

?>