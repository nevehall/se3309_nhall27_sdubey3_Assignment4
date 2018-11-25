<?php  
require "../../config.php";

if (isset($_POST['username']) and isset($_POST['pass'])){
	
    // Assigning POST values to variables.
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    
    // CHECK FOR THE RECORD FROM TABLE
    $mysql = "SELECT employeeNo FROM c9.Employee WHERE username='$username' and pass='$pass'";
    
     
    $result = mysqli_query($db, $mysql) or die(mysqli_error($db));
    
    echo '<script>console.log($mysql)</script>';
    $count = mysqli_num_rows($result);
    
//STILL NEED TO: show valid/invalid pop-up
//user can bypass login through URL

    if ($count == 1){
    
        //echo "Login Credentials verified";
        header("Location: ../index.php");
        echo "<script type='text/javascript'>alert('Login Credentials verified')</script>";
    
    }else{
        echo "<script type='text/javascript'>alert('Invalid Login Credentials')</script>";
        //echo "Invalid Login Credentials";
       header("Location: login.php");
    }
};
?> 