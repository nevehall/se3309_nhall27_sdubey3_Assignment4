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
	<li><a href="./views/ski.php"><strong>Ski</strong></li>
	<li><a href="./views/snowboard.php"><strong>Snowboard</strong></a></li>
	<li><a href="./views/helmet.php"><strong>Helmet</strong></a></li>
	<li><a href="./views/boots.php"><strong>Boots</strong></a></li>
</ul>


<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>