<?php
$conn = mysqli_connect("localhost","root","","FileUpload");

$sql = "SELECT * FROM FILES";
$result = mysqli_query($conn, $sql);
$files = mysqli_fetch_all($result, MYSQLI_ASSOC);

// function processUpload($filename, $destination) {

// }

//
//
// if(isset($_POST['Upload'])) {
//     $filename = $_FILES['myfile']['name'];
//     $destination = "uploads/";
//     $destinationFile = 'uploads/'.$filename;
//
//     if(!is_dir($destination)) {
//         mkdir($destination);
//     }
//
//     // <!-- Gets the extension of the filename -->
//     // processUpload($filename, $destination);
//     $extension = pathinfo($filename, PATHINFO_EXTENSION);
//
//     $file = $_FILES['myfile']['tmp_name'];
//
//     $size = $_FILES['myfile']['size'];
//
//     if(!in_array($extension, ['docx','pdf','doc'])) {
//         echo "Your file extension must be .zip,.pdf or .png";
//     }
//     elseif($_FILES['myfile']['size'] > 10000000) {
//         echo "File is too large";
//     }
//     else {
//         if(move_uploaded_file($file, $destinationFile)) {
//             $query = "INSERT INTO FILES (name,size, downloads) VALUES ('$filename','$size',0)";
//             if(mysqli_query($conn, $query)) {
//                 echo "File uploaded Successfully";
//             }
//             else {
//                 echo "Failed to upload";
//             }
//         }
//     }
// }

$year ="";
$semester = "";
$section = "";
$destination = "";


// Code for Time Tables uplaod
if(isset($_POST['file-upload'])) {

    if(!empty($_POST['year'])) {
        foreach($_POST['year'] as $yearSelected) {
            $year = $yearSelected;
            echo "Selected Year: ".$year;
        }
    }
    if(!empty($_POST['semester'])) {
        foreach($_POST['semester'] as $semSelected) {
            $semester = $semSelected;
            echo "Selected Semester: ".$semSelected;
        }
    }
    if(!empty($_POST['section'])) {
        foreach($_POST['section'] as $sectionSelected) {
            $section = $sectionSelected;
            echo "Selected Section: ".$sectionSelected;
        }
    }

    if($year == "1" || $year == "2" || $year == "3") {
        if($semester == "1" || $semester == "2" || $semester == "3" || $semester = "4" || $semester == "5" || $semester == "6") {
            if($section == "A" || $section == "B") {
                $filename = $_FILES['myfile']['name'];
                // require_once $_SERVER['DOCUMENT_ROOT']."/Department/filesLogicdup.php"
                $destination = "Uploads/Timetables/".$year." Year/".$semester." Semester/".$section." Section/";
                echo $destination;
                $destinationFile = "Uploads/Timetables/".$year." Year/".$semester." Semester/".$section." Section/".$filename;
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
                        $query = "INSERT INTO FILES (name,size, downloads) VALUES ('$filename','$size',0)";
                        if(mysqli_query($conn, $query)) {
                            echo "File uploaded Successfully";
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
}

echo "\n year: ".$year;
echo "\n Semester: ".$semester;
echo "\n Section: ".$section;




if(isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    echo "file id: ". $id;

    $sql = "select * from files where id=$id";

    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);

    //$filepath = 'uploads/' .$file['name'];
    $filepath = "Uploads/Timetables/".$year." Year/".$semester." Semester/".$section." Section/".$file['name'];

    print_r("\n File path: ".$filepath);


    if(file_exists($filepath)) { //is_file

        $len = filesize("Uploads/Timetables/".$year." Year/".$semester." Semester/".$section." Section/".$file['name']);
        $filename = basename($filepath);
        $file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        echo " length:".$len;
        echo " Filename: ".$filename;
        echo " Extension: ".$file_extension;

        switch($file_extension){
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            default: $ctype="appllication/force-download";
        }

        ob_clean();
        // Begin headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: $ctype");
        // Force the download
        $header = "Content-Disposition: attachment; filename=".$filename.";";
        header($header);
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".$len);
        //@readfile($filename);

        @readfile("Uploads/Timetables/".$year." Year/".$semester." Semester/".$section." Section/".$file['name']);

        // $newCount = $file['downloads'] + 1;
        //
        // $updateQuery = "update files set downloads=$newCount where id=$id";
        //
        // mysqli_query($conn, $updateQuery);

        exit;
      }

}

?>
