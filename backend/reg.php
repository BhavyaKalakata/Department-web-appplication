<?php
  session_start();
  $conn = mysqli_connect("localhost","root","","userdb");

  $username = $_POST['name'];
  $email = $_POST['email'];
  $pwd = $_POST['psw'];

  $query = "select * from Users where name='$username'";
  $check_result = mysqli_query($conn, $query);
  if(mysqli_num_rows($check_result) == 1) {
    echo "<h1>Username already taken<h1>";
  }

  else {
    $ins_query = "insert into Users(name,password,email) VALUES ('$username','$pwd','$email');";
    if(mysqli_query($conn, $ins_query)) {
      echo "Registration Successful";
      header('location:login.html');
    }
    else {
      echo "Registration Failed";
      header('location:reg.html');
    }

    //header('location:login.html');
  }
 ?>
