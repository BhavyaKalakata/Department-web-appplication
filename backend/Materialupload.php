<?php
  //header('Content-Type: application/json');
  $conn = mysqli_connect("localhost","root","","FileUpload");
  $year = $_POST['year'];
  $semester = $_POST['semester'];
  $section = $_POST['section']
  $destination = "";
  $path = $_SERVER['DOCUMENT_ROOT'];

  echo "year: ".$year;
  echo "semester :".$semester;
  echo "section: ".$section;
    // if(!empty($_POST['year'])) {
    //     foreach($_POST['year'] as $yearSelected) {
    //         $year = $yearSelected;
    //         echo "Selected Year: ".$year;
    //     }
    // }
    // if(!empty($_POST['semester'])) {
    //     foreach($_POST['semester'] as $semSelected) {
    //         $semester = $semSelected;
    //         echo "Selected Semester: ".$semSelected;
    //     }
    // }
    // if(!empty($_POST['section'])) {
    //     foreach($_POST['section'] as $sectionSelected) {
    //         $section = $sectionSelected;
    //         echo "Selected Section: ".$sectionSelected;
    //     }
    // }

    if($year == "1" || $year == "2" || $year == "3") {
        if($semester == "1" || $semester == "2" || $semester == "3" || $semester = "4" || $semester == "5" || $semester == "6") {
            if($section == "A" || $section == "B") {
                $filename = $_FILES['myfile']['name'];
                // require_once $_SERVER['DOCUMENT_ROOT']."/Department/filesLogicdup.php"
                $destination = $path."/Uploads/Materials/".$year." Year/".$semester." Semester/".$section." Section/";
                echo $destination;
                $destinationFile = $path."/Uploads/Materials/".$year." Year/".$semester." Semester/".$section." Section/".$filename;
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
                        $query = "INSERT INTO Materials (name,year, semester,section,size,downloads,filepath) VALUES ('$filename',$year,$semester,'$section','$size',0,'$destination')";
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
        }
    }

?>
