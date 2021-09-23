<?php
  //header('Content-Type: application/json');
  $conn = mysqli_connect("localhost","root","","FileUpload");
  $event = $_POST['event'];
  $destination = "";
  $path = $_SERVER['DOCUMENT_ROOT'];


  echo "Event: ".$event;

    if($event == "Internal" || $event == "External" || $event == "Organizing") {
                $filename = $_FILES['myfile']['name'];
                // require_once $_SERVER['DOCUMENT_ROOT']."/Department/filesLogicdup.php"
                $destination = $path."/backend/Uploads/Events/".$event." Events/";
                echo $destination;
                $destinationFile = $path."/backend/Uploads/Events/".$event." Events/".$filename;
                //echo "\n".$destination;
                // processUpload($filename, $destination);

                if(!is_dir($destination)) {
                    mkdir($destination,0777,true);
                }

                $extension = pathinfo($filename, PATHINFO_EXTENSION);

                $file = $_FILES['myfile']['tmp_name'];

                $size = $_FILES['myfile']['size'];

                if(!in_array($extension, ['docx','pdf','doc'])) {
                    echo "Your file extension must be .zip,.pdf or .png";
                }
                elseif($_FILES['myfile']['size'] > 20000000) {
                    echo "File is too large";
                }
                else {
                  if(!file_exists($destinationFile)) {
                    if(move_uploaded_file($file, $destinationFile)) {
                        $query = "INSERT INTO Events (name,typeof,size,downloads,filepath) VALUES ('$filename','$event','$size',0,'$destination')";
                        if(mysqli_query($conn, $query)) {
                            echo '<script>alert("File uploaded Successfully");</script>';
                        }
                        else {
                            echo "Failed to upload";
                        }
                    }
                  }
                  else {
                    echo "File Already Exists";
                  }

                }
    }

?>
