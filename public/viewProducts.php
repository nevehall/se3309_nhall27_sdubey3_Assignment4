<?php require "templates/header.php"; ?>
<?php
/**
 * List the products available to vieww
 */
require "../config.php";
require "../common.php";
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "SELECT * FROM Product";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
        
<h2>Select a Product to View</h2>

<ul>
	<li><a href="./viewProducts/ski.php"><strong>Skis</strong></li>
	<li><a href="./viewProducts/snowboard.php"><strong>Snowboards</strong></a></li>
	<li><a href="./viewProducts/helmet.php"><strong>Helmets</strong></a></li>
	<li><a href="./viewProducts/boots.php"><strong>Boots</strong></a></li>
	<li><a href="./viewProducts/popularBrand.php"><strong>Brand Statistics</strong></a></li>
	<li><a href="./viewProducts/popularItem.php"><strong>Product Statistics</strong></a></li>

</ul>


<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>