<?php
  $conn = mysqli_connect("localhost","root","","Fileupload");
  $eventtype = $_GET['event_type'];
  $destination = "";
  $id = "";
  $query = "select * from events where typeof='$eventtype'";
  $result = mysqli_query($conn, $query);


  while($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
    //echo "Destination: ".$destination;
  }

  $query2 = "select * from events where id=$id";
  $result2 = mysqli_query($conn, $query2);

  while($row2 = mysqli_fetch_array($result2)) {
    $destination = $row2['filepath'].$row2['name'];
    echo "Destination: ".$destination;
  }

  if(!file_exists($destination)) {
    echo "File not exists";
  }

  else {
    unlink($destination);
    $deleteQuery = "delete from events where id=$id";
    $deleteresult = mysqli_query($conn,$deleteQuery);
    if($deleteresult) {
      echo "Deleted File Successfully from DB";
      echo "<h3 style='color:green'>Deleted Selected File Successfully</h3>";
    }
    else {
      echo "Failed to delete file from DB";
      echo "<h3 style='color:red'>Error!!</h3>";
    }
  }

  mysqli_close($conn);

?>
