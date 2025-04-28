<?php
    //start the session
    session_start();
    require 'connect.php';

    //get the user id
    $id=$_SESSION['user_id'];
    //get username through AJAX
    $username=$_POST['username'];

    //run the query
    $sql="UPDATE users SET username='$username' WHERE user_id='$id'";
    $result=mysqli_query($con,$sql);
    if(!$result)
    {
        echo '<div class="alert alert-danger">There was error upadating username!</div>';
    }
?>