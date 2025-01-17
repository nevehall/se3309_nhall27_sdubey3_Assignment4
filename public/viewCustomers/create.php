<?php require "../templates/header.php"; ?>

<?php
/**
 * Use an HTML form to create a new entry in the
 * customers table.
 *
 */
if (isset($_POST['submit'])) {
    require "../../config.php";
    require "../../common.php";
    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_customer = array(
            "customerEmail" => $_POST['customerEmail'],
            "fname" => $_POST['fname'],
            "lname"  => $_POST['lname'],
            "customerPhone" => $_POST['customerPhone'],
            "height" => $_POST['height'],
            "weight" => $_POST['weight']
            
            
        );
        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "Customer",
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


<h2>Add a Customer</h2>

<form method="post">
    <label for="customerEmail">Customer Email: </label>
    <input type="text" name="customerEmail" id="customerEmail">
    
    <label for="fname">First Name: </label>
    <input type="text" name="fname" id="fname">
    
    <label for="lname">Last Name: </label>
    <input type="text" name="lname" id="lname">
    
    <label for="customerPhone">Customer Phone: </label>
    <input type="text" name="customerPhone" id="customerPhone">
    
    <label for="height">Height: </label>
    <input type="text" name="height" id="height">
    
    <label for="weight">Weight: </label>
    <input type="text" name="weight" id="weight">
    
    <input type="submit" name="submit" value="Submit">
</form>

<link rel="stylesheet" type="text/css" href="../css/style.css">

<a href="../viewCustomers.php">Back to Customer Info</a>

<?php require "../templates/footer.php"; ?>