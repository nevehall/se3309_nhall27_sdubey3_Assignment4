<?php require "../templates/header.php"; ?>

<?php

if (isset($_POST['submit'])) {
    require "../../config.php";
    require "../../common.php";
    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_transaction = array(
            //"transactionID" => $_POST['SET transactionID = SELECT RAND()*(100000000-999999999)+100000000'],
            "employeeNo" => $_POST['employeeNo'],
            "time"  => $_POST['time'],
            "date" => $_POST['date'],
            "total" => $_POST['total'],
            "customerEmail" => $_POST['customerEmail']
            
        );
        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "Transactions",
                "SET transactionID = SELECT RAND()*(100000000-999999999)+100000000;",
                implode(", ", array_keys($new_transaction)),
                ":" . implode(", :", array_keys($new_transaction))
                
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_transaction);
        ?>
            <blockquote><?php echo $_POST['transactionID']; ?> successfully processed.</blockquote>
        <?php
    } catch(PDOException $error) {
        echo $_POST['transactionID'] . "already exists in the database.";
    }
}
?>


<h2>Process a Transaction</h2>

<form method="post">
   
    <label for="employeeNo">Provide your employeeNo: </label>
    <input type="text" name="employeeNo" id="employeeNo">
    
    <label for="customerEmail">Customer Email: </label>
    <input type="text" name="customerEmail" id="customerEmail">
    
    <label for="total">Total: </label>
    <input type="text" name="total" id="total">
    
    
    
    
    
    <input type="submit" name="submit" value="Submit">
</form>

<a href="../transactions.php">Back to Transactions</a>

<?php require "../templates/footer.php"; ?>