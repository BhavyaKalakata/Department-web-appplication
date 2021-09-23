<?php
  session_start();
  $res = session_destroy();
  if($res) {
    echo "<h1>Logged out successful</h1>";
  }
  else {
    echo "Logout Failure";
  }
 ?>
