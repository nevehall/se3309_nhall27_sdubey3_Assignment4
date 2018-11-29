<?php require "../templates/header.php"; ?>

 <link rel="stylesheet" type="text/css" href="../css/style.css">

<?php
/**
 * View Customer Transaction history
 *
 */

require "../../config.php";
require "../../common.php";
if (isset($_POST['submit'])) {
    try  {
        
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



<h2>Find Customer Transaction History</h2>
<link rel="stylesheet" type="text/css" href="../css/style.css">


<form method="post">
    <label for="customerEmail">Customer Email </label>
    <input type="text" id="customerEmail" name="customerEmail">
    <input type="submit" name="submit" value="View Results">
</form>


<a href="../transactions.php">Back to Transaction Info</a>

<?php require "../templates/footer.php"; ?>