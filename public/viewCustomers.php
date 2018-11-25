<?php require "templates/header.php"; ?>
<?php
/**
 * List the products available to vieww
 */
require "../config.php";
require "../common.php";
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "SELECT * FROM Customer";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
        
<h2>Select a Product to View</h2>

<ul>
	<li><a href="./viewCustomers/create.php"><strong>Create</strong></a> - add a customer</li>
	<li><a href="./viewCustomers/search.php"><strong>Search</strong></a> - find a customer</li>
	<li><a href="./viewCustomers/update.php"><strong>Update</strong></a> - update a customer</li>
	<li><a href="./viewCustomers/delete.php"><strong>Delete</strong></a> - delete a customer</li>
</ul>


<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>