<?php require "templates/header.php"; ?>
<?php
/**
 * List the transaction option
 */
require "../config.php";
require "../common.php";
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "SELECT * FROM Transactions";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
        
<h2>Transactions</h2>

<ul>
	<li><a href="./transactions/processTransaction.php"><strong>Process a Transaction</strong></a></li>
	<li><a href="./transactions/transactionHistory.php"><strong>View Store Transation History</strong></a></li>
	<li><a href="./transactions/employeeTransRecord.php"><strong>View Employee Transaction Record</strong></a></li>

</ul>


<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>