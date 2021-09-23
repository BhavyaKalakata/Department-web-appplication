<?php

$conn = mysqli_connect("localhost","root","","Fileupload");

$downloadType = '';

function doDownload($tempid,$conn, $determineFileType) {

    $sql = "";
    $id = $tempid;

    $filename = "";

    echo "file id: ". $id;

    if($determineFileType == 'Timetableid') {
        $sql = "select * from timetables where id=$id";
    }
    else if($determineFileType == 'Matid') {
        $sql = "select * from materials where id=$id";
    }
    else if($determineFileType == 'SylId') {
      $sql = "select * from syllabus where id=$id";
    }
    else if($determineFileType == 'Notificationid') {
      $sql = "Select * from notifications where id=$id";
    }

    $result = mysqli_query($conn, $sql);
    // $file = mysqli_fetch_assoc($result);

    while($row = mysqli_fetch_array($result)) {
        echo "id from path: ".$row['id'];
        $filename = $row['filepath'].$row['name'];
    }

    //$filepath = 'uploads/' .$file['name'];
    $filepath = $filename;

    print_r("\n File path: ".$filepath);


    if(file_exists($filepath)) { //is_file

        $len = filesize($filepath);
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

        @readfile($filepath);

        // $newCount = $file['downloads'] + 1;
        //
        // $updateQuery = "update files set downloads=$newCount where id=$id";
        //
        // mysqli_query($conn, $updateQuery);

        exit;
  }

} /*end of function*/


if(isset($_GET['timetableid'])) {
    $timetableid = $_GET['timetableid'];
    $downloadType = 'Timetableid';
    doDownload($timetableid,$conn,$downloadType); /* For Timetable download */
}
else if(isset($_GET['matid'])) {
    $matid = $_GET['matid'];
    $downloadType = 'Matid';
    doDownload($matid,$conn,$downloadType);
}
else if(isset($_GET['syllabusid'])) {
    $syllabusId = $_GET['syllabusid'];
    $downloadType = 'SylId';
    doDownload($syllabusId,$conn,$downloadType);
}
else if(isset($_GET['notificationid'])) {
  $notificationId = $_GET['notificationid'];
  $downloadType = 'Notificationid';
  doDownload($notificationId,$conn,$downloadType);
}


?>
