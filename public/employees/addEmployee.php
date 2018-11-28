<?php require "../templates/header.php"; ?>

<?php
/**
 * Use an HTML form to create a new entry in the
 * employees table.
 *
 */
if (isset($_POST['submit'])) {
    require "../../config.php";
    require "../../common.php";
    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_customer = array(
            "employeeNo" => $_POST['employeeNo'],
            "username" => $_POST['username'],
            "pass"  => $_POST['pass'],
            "fname" => $_POST['fname'],
            "lname" => $_POST['lname'],
            "employeePhone" => $_POST['employeePhone']
            
            
        );
        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "Employee",
                implode(", ", array_keys($new_customer)),
                ":" . implode(", :", array_keys($new_customer))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_customer);
        ?>
            <blockquote><?php echo $_POST['fname']; ?> successfully added.</blockquote>
        <?php
    } catch(PDOException $error) {
        echo $_POST['fname'] . "already exists in the database.";
    }
}
?>

<link rel="stylesheet" type="text/css" href="../css/style.css">


<h2>Add a Customer</h2>

<form method="post">
    <label for="employeeNo">Employee Number: </label>
    <input type="text" name="employeeNo" id="employeeNo">
    
    <label for="username">Username: </label>
    <input type="text" name="username" id="username">
    
    <label for="pass">Password: </label>
    <input type="text" name="pass" id="pass">
    
    <label for="fname">First Name: </label>
    <input type="text" name="fname" id="fname">
    
    <label for="lname">Last Name: </label>
    <input type="text" name="lname" id="lname">
    
    <label for="employeePhone">Customer Phone: </label>
    <input type="text" name="employeePhone" id="employeePhone">
    
    <input type="submit" name="submit" value="Submit">
</form>

<link rel="stylesheet" type="text/css" href="../css/style.css">

<a href="../employees.php">Back to Employee Info</a>

<?php require "../templates/footer.php"; ?>