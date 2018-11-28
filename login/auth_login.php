<?php  


require "../config.php";

if (isset($_POST['username']) and isset($_POST['pass'])){
	
    // Assigning POST values to variables.
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    
    // CHECK FOR THE RECORD FROM TABLE
    $mysql = "SELECT employeeNo FROM c9.Employee WHERE username='$username' and pass='$pass'";
    $result = mysqli_query($db, $mysql) or die(mysqli_error($db));
    $count = mysqli_num_rows($result);
    
    if ($count == 1){
        
        header("Location: ../public/index.php");

    } else{
        ?>
        <blockquote><?php echo $_POST['username']; ?>does not exist in the database.</blockquote>
        <?php
       header("Location: login.php");
    }
}
?>