<?php


    function uploadPhoto(){
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        if ($uploadOk == 1){
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                _getGPSMetaData($target_file);
            }
        }
    }
     function _getGPSMetaData($filename){
        $exif = exif_read_data($filename);
        if (empty($exif)){
            echo "file not found";
            return;
        }
        else {
            $latitude = _getGPSLocation($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
            $longitude = _getGPSLocation($exif["GPSLongitude"], $exif['GPSLongitudeRef']);

            echo "latitude: " . $latitude;
            echo "longitude" . $longitude;
            }
        }
         function _getGPSLocation($coordinate, $hemisphere){
        for ($i = 0; $i < 3; $i++) {
            $part = explode('/', $coordinate[$i]);
            if (count($part) == 1) {
                $coordinate[$i] = $part[0];
            } else if (count($part) == 2) {
                $coordinate[$i] = floatval($part[0])/floatval($part[1]);
            } else {
                $coordinate[$i] = 0;
            }
        }
        list($degrees, $minutes, $seconds) = $coordinate;
        $sign = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
        return $sign * ($degrees + $minutes/60 + $seconds/3600) . "<br />";
    }




if (isset($_POST['submit']) ) {
  uploadPhoto();
}
?>



<!DOCTYPE html>
<html>
<body>
<form method="POST" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
