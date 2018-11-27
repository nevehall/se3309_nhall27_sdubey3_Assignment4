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
                    <th><input type="submit" name="submitTotal" value="Calculate Total"></th>
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
 * View grand total amount spent at the store by specified customer.
 *
 */
if (isset($_POST['submitTotal'])) {
    try  {
        
        //require "../../config.php";
        //require "../../common.php";
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT customerEmail, SUM(total) AS grandTotal
                    FROM Transactions 
                    GROUP BY grandTotal";
        $grandTotal = $_POST['grandTotal'];
        $statement = $connection->prepare($sql);
        $statement->bindParam(':grandTotal', $grandTotal, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php  
if (isset($_POST['submitTotal'])) {
    if ($result && $statement->rowCount() > 5) { ?>
        <table>
            <thead>
                <tr>
                    <th>Grand Total</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["grandTotal"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>Can't find grand total</blockquote>
    <?php } 
} ?> 







<h2>Find Customer Transaction History</h2>

<form method="post">
    <label for="customerEmail">Customer Email </label>
    <input type="text" id="customerEmail" name="customerEmail">
    <input type="submit" name="submit" value="View Results">
    <th><input type="submit" name="submitTotal" value="Calculate Total"></th>
</form>

<a href="../transactions.php">Back to Transaction Info</a>

<?php require "../templates/footer.php"; ?>