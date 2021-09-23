<?php
  //header('Content-Type: application/json');
  $conn = mysqli_connect("localhost","root","","FileUpload");
  $year = $_POST['year'];
  $semestermat = $_POST['semester'];
  $section = $_POST['section'];
  $destination = "";
  $path = $_SERVER['DOCUMENT_ROOT'];

  echo "<br /> Path: ".$path."<br />";

  echo "year: ".$year;
  echo "semester :".$semestermat;
  echo "section: ".$section;
    // if(!empty($_POST['year'])) {
    //     foreach($_POST['year'] as $yearSelected) {
    //         $year = $yearSelected;
    //         echo "Selected Year: ".$year;
    //     }
    // }
    // if(!empty($_POST['semester'])) {
    //     foreach($_POST['semester'] as $semSelected) {
    //         $semestermat = $semSelected;
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
        if($semestermat == "1" || $semestermat == "2" || $semestermat == "3" || $semestermat == "4" || $semestermat == "5" || $semestermat == "6") {
            if($section == "A" || $section == "B") {
                $filename = $_FILES['myfile']['name'];
                $destination = $path."/backend/Uploads/Notifcations/".$year." Year/".$semestermat." Semester/".$section." Section/";
                echo $destination;
                $destinationFile = $path."/backend/Uploads/Notifcations/".$year." Year/".$semestermat." Semester/".$section." Section/".$filename;
            

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
                        $query = "INSERT INTO Notifications (name,year, semester,section,size,downloads,filepath) VALUES ('$filename',$year,$semestermat,'$section','$size',0,'$destination')";
                        if(mysqli_query($conn, $query)) {
                            echo 'File uploaded Successfully';
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
