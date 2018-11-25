<?php require "../templates/header.php"; ?>
<?php
/**
 * List all customers with a link to edit
 */
require "../../config.php";
require "../../common.php";
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql ="SELECT t.transactionID, t.employeeNo, t.transTime, t.transDate, t.total, 
        t.customerEmail, i.itemID, p.productNo
        FROM Transactions t, Item i, Product p
        WHERE i.transactionID = t.transactionID AND i.productNo = p.productNo";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
        
<h2>Store Transaction History</h2>
<a href="../transactions.php">Back to Transactions</a>

<table>
    <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Employee No</th>
            <th>Customer Email</th>
            <th>Time</th>
            <th>Date</th>
            <th>Product No</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["transactionID"]); ?></td>
            <td><?php echo escape($row["employeeNo"]); ?></td>
            <td><?php echo escape($row["customerEmail"]); ?></td>
            <td><?php echo escape($row["transTime"]); ?></td>
            <td><?php echo escape($row["transDate"]); ?></td>
            <td><?php echo escape($row["productNo"]); ?></td>
            <td><?php echo escape($row["total"]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require "../templates/footer.php"; ?>