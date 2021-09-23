<?php
  session_start();
  $conn = mysqli_connect("localhost","root","","userdb");

  $username = $_POST['user'];
  // $email = $_POST['email'];
  $pwd = $_POST['pass'];

  $query = "select * from Users where name='$username' and password='$pwd'";
  $check_result = mysqli_query($conn, $query);
  if(mysqli_num_rows($check_result) == 1) {
    $_SESSION['Username'] = $username;
    header('location:columndup.php');
  }
  else {
    header('location:login.html');
  }

 ?>
