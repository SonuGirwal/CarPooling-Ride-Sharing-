<?php
session_start();
require 'connect.php';

$user_id = $_SESSION['user_id'];
//function
function uploadPrifilePicture($id,$file,$ext,$con)
{
    $targetDir='../profilepicture/' . md5(time()) . ".$ext";
    if(move_uploaded_file($file,$targetDir))
    {
        $sql="UPDATE users SET profilepicture='$targetDir' WHERE user_id='$id'";
        $result=mysqli_query($con,$sql);
        if(!$result)
        {
            $resultMessage='<div class="alert alert-danger">Unable to update database . Please try again!.</div>';
            echo $resultMessage;  
        }
    }
    else
    {
        $resultMessage='<div class="alert alert-warning">Unable to upload file . Please try again!.</div>';
        echo $resultMessage;  
    }
}

$errors='';
//error messages to display
$noFiletoUpload = "<p><strong>Please select a file to upload !</strong></p>";
$wrontFormat = "<p><strong>Sorry, you can only upload jpeg jpg and png file !</strong></p>";
$fileTooLarge = "<p><strong>You can only upload files smaller than 3Mo!</strong></p>";

//file details
$name = $_FILES["picture"]["name"];
$type = $_FILES["picture"]["type"];
$size = $_FILES["picture"]["size"];
$fileerror = $_FILES["picture"]["error"];
$tmp_name = $_FILES["picture"]["tmp_name"];
$extension = pathinfo($name, PATHINFO_EXTENSION);

//allowed formats to upload
$allowedFormats = array("jpeg"=>"image/jpeg", "jpg"=>"image/jpg", "png"=>"image/png");


//check for errors
if($fileerror==4)
{
    $errors.=$noFiletoUpload;
}
else
{
    if(!in_array($type,$allowedFormats))
    {
        $errors.=$wrontFormat;
    }
    elseif($size>3*1024*1024)
    {
        $errors.=$fileTooLarge;
    }
}
//display errors
if($errors)
{
    $resultMessage='<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage; 
}
else
{
    uploadPrifilePicture($user_id,$tmp_name,$extension,$con);
}

?>