<?php require "../templates/header.php"; ?>

<?php
/**
 * View Customer Transaction history
 *
 */

if (isset($_POST['submit'])) {
    try  {
        
        require "../../config.php";
        require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT * 
                        FROM Transactions
                        WHERE customerEmail = :customerEmail";
        /*$sql ="CREATE VIEW CustomerHistory1
                    AS SELECT *
                    FROM Transactions
                    WHERE customerEmail = :customerEmail";
                "SELECT * FROM CustomerHistory1";*/
        $customerEmail = $_POST['customerEmail'];
        $statement = $connection->prepare($sql);
        $statement->bindParam(':customerEmail', $customerEmail, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();
    }catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
        
<?php  
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <h2>Results</h2>
        <blockquote>All transactions placed by <?php echo escape($_POST['customerEmail']); ?>.</blockquote>

        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Employee No</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Grand Total</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["transactionID"]); ?></td>
                <td><?php echo escape($row["employeeNo"]); ?></td>
                <td><?php echo escape($row["transTime"]); ?></td>
                <td><?php echo escape($row["transDate"]); ?></td>
                <td><?php echo escape($row["total"]); ?></td>
                <td><?php echo escape($row["bigTotal"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['customerEmail']); ?>.</blockquote>
    <?php } 
} ?> 


<?php
/**
 * Trying to get the grand total working, so that it just outputs when you 
 * submit "view results."
 *
 */

if (isset($_POST['submit'])) {
    try  {
        
        require "../../config.php";
        require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT customerEmail, transactionID, total, SUM(total) AS bigTotal 
                FROM
                ( 
                    SELECT c.customerEmail, t.transactionID, t.total,
                        SUM(t.total) AS total
                        FROM Customer c
                            INNER JOIN Transactions t
                            ON c.customerEmail = t.customerEmail
                        GROUP BY c.customerEmail
                ) 
                GROUP BY customerEmail, transactinoID, total";
                
                        //WHERE customerEmail = :customerEmail";
       
        //$customerEmail = $_POST['customerEmail'];
        $statement = $connection->prepare($sql);
        //$statement->bindParam(':customerEmail', $customerEmail, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();
    }catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>



<?php
/**
 * View grand total amount spent at the store by specified customer.
 *
 */
/*if (isset($_POST['submitTotal'])) {
    try  {
        
        require "../../config.php";
        require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT t.customerEmail, SUM(total) AS grandTotal
                    FROM Customer c, Transactions t
                    WHERE c.customerEmail = t.customerEmail
                    GROUP BY t.customerEmail";
        $customerEmail = $_POST['customerEmail'];
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}*/
?>

<?php  
/*if (isset($_POST['submitTotal'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Grand Total</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["customerEmail"]); ?></td>
                <td><?php echo escape($row["grandTotal"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>Can't find grand total</blockquote>
    <?php } 
} */?> 








<h2>Find Customer Transaction History</h2>
<link rel="stylesheet" type="text/css" href="../css/style.css">


<form method="post">
    <label for="customerEmail">Customer Email </label>
    <input type="text" id="customerEmail" name="customerEmail">
    <input type="submit" name="submit" value="View Results">
    <th><input type="submit" name="submitTotal" value="Calculate Total"></th>
</form>


<a href="../transactions.php">Back to Transaction Info</a>

<?php require "../templates/footer.php"; ?>