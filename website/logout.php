<?php

  session_start();
  include 'https.php';
  unset($_SESSION['user']);
  unset($_SESSION['send_recovery']);
  $_SESSION['login'] = "logout";
  header("location: index.php");
  
?>